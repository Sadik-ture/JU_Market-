<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // NO CONSTRUCTOR NEEDED - Laravel 12 doesn't use middleware() in constructor

    // Show rating form after payment
    public function create(Payment $payment)
    {
        // Check if user can rate (must be buyer and payment completed)
        if ($payment->buyer_id !== auth()->id()) {
            abort(403);
        }

        if ($payment->status !== 'completed') {
            return back()->with('error', 'You can only rate after payment is completed.');
        }

        // Check if already rated
        $existingRating = Rating::where('payment_id', $payment->id)
            ->where('from_user_id', auth()->id())
            ->first();

        if ($existingRating) {
            return redirect()->route('ratings.edit', $existingRating);
        }

        return view('ratings.create', compact('payment'));
    }

    // Store rating
    public function store(Request $request, Payment $payment)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $payment->seller_id,
            'listing_id' => $payment->listing_id,
            'payment_id' => $payment->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_approved' => true,
        ]);

        // Update user average rating
        $seller = $payment->seller;
        $avgRating = $seller->receivedRatings()->where('is_approved', true)->avg('rating');
        $seller->update(['rating_avg' => $avgRating]);

        return redirect()->route('listings.show', $payment->listing_id)
            ->with('success', 'Thank you for rating this seller!');
    }

    // Edit rating
    public function edit(Rating $rating)
    {
        if ($rating->from_user_id !== auth()->id()) {
            abort(403);
        }

        return view('ratings.edit', compact('rating'));
    }

    // Update rating
    public function update(Request $request, Rating $rating)
    {
        if ($rating->from_user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $rating->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Update seller average rating
        $seller = $rating->toUser;
        $avgRating = $seller->receivedRatings()->where('is_approved', true)->avg('rating');
        $seller->update(['rating_avg' => $avgRating]);

        return redirect()->route('profile.show', $rating->to_user_id)
            ->with('success', 'Your review has been updated.');
    }

    // Display user ratings
    public function userRatings(User $user)
    {
        $ratings = $user->receivedRatings()
            ->where('is_approved', true)
            ->with(['fromUser', 'listing'])
            ->latest()
            ->paginate(20);

        return view('ratings.user', compact('user', 'ratings'));
    }
}
