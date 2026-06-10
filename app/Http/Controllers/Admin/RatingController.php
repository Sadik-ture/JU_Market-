<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // Display all ratings
    public function index(Request $request)
    {
        $query = Rating::with(['fromUser', 'toUser', 'listing']);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status == 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Filter by rating value
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search by user or review
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('review', 'like', '%'.$request->search.'%')
                    ->orWhereHas('fromUser', function ($sub) use ($request) {
                        $sub->where('name', 'like', '%'.$request->search.'%');
                    })
                    ->orWhereHas('toUser', function ($sub) use ($request) {
                        $sub->where('name', 'like', '%'.$request->search.'%');
                    });
            });
        }

        $ratings = $query->latest()->paginate(20);

        // Stats
        $stats = [
            'total' => Rating::count(),
            'approved' => Rating::where('is_approved', true)->count(),
            'pending' => Rating::where('is_approved', false)->count(),
            'average_rating' => Rating::where('is_approved', true)->avg('rating') ?? 0,
            'five_stars' => Rating::where('rating', 5)->where('is_approved', true)->count(),
            'four_stars' => Rating::where('rating', 4)->where('is_approved', true)->count(),
            'three_stars' => Rating::where('rating', 3)->where('is_approved', true)->count(),
            'two_stars' => Rating::where('rating', 2)->where('is_approved', true)->count(),
            'one_star' => Rating::where('rating', 1)->where('is_approved', true)->count(),
        ];

        return view('admin.ratings', compact('ratings', 'stats'));
    }

    // Approve a rating
    public function approve(Rating $rating)
    {
        $rating->update(['is_approved' => true]);

        // Update user average rating
        $seller = $rating->toUser;
        $avgRating = $seller->receivedRatings()->where('is_approved', true)->avg('rating');
        $seller->update(['rating_avg' => $avgRating]);

        return back()->with('success', 'Rating approved successfully.');
    }

    // Reject/Delete a rating
    public function destroy(Rating $rating)
    {
        $seller = $rating->toUser;
        $rating->delete();

        // Update user average rating
        $avgRating = $seller->receivedRatings()->where('is_approved', true)->avg('rating');
        $seller->update(['rating_avg' => $avgRating]);

        return back()->with('success', 'Rating removed successfully.');
    }

    // Bulk approve
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        Rating::whereIn('id', $ids)->update(['is_approved' => true]);

        // Update all affected sellers
        $ratings = Rating::whereIn('id', $ids)->get();
        foreach ($ratings as $rating) {
            $seller = $rating->toUser;
            $avgRating = $seller->receivedRatings()->where('is_approved', true)->avg('rating');
            $seller->update(['rating_avg' => $avgRating]);
        }

        return back()->with('success', count($ids).' ratings approved successfully.');
    }

    // Bulk delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        Rating::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids).' ratings deleted successfully.');
    }

    // View rating details
    public function show(Rating $rating)
    {
        return view('admin.rating-details', compact('rating'));
    }

    // Top rated sellers
    public function topSellers()
    {
        $topSellers = User::whereHas('receivedRatings', function ($q) {
            $q->where('is_approved', true);
        })
            ->withCount(['receivedRatings as ratings_count' => function ($q) {
                $q->where('is_approved', true);
            }])
            ->withAvg(['receivedRatings as avg_rating' => function ($q) {
                $q->where('is_approved', true);
            }], 'rating')
            ->having('ratings_count', '>', 0)
            ->orderBy('avg_rating', 'desc')
            ->limit(10)
            ->get();

        return view('admin.top-sellers', compact('topSellers'));
    }
}
