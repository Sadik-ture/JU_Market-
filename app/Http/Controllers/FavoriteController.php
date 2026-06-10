<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Listing;

class FavoriteController extends Controller
{
    // Add to favorites
    public function add(Listing $listing)
    {
        // Check if already favorited
        if (auth()->user()->hasFavorited($listing->id)) {
            return back()->with('info', 'This item is already in your favorites.');
        }

        // Add to favorites
        Favorite::create([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
        ]);

        return back()->with('success', 'Added to favorites! ❤️');
    }

    // Remove from favorites
    public function remove(Listing $listing)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return back()->with('success', 'Removed from favorites.');
        }

        return back()->with('error', 'Item not in your favorites.');
    }

    // View all favorites
    public function index()
    {
        $favorites = auth()->user()->favoriteListings()
            ->with('user', 'photos')
            ->latest()
            ->paginate(20);

        return view('favorites.index', compact('favorites'));
    }

    // Toggle favorite (AJAX-ready)
    public function toggle(Listing $listing)
    {
        if (auth()->user()->hasFavorited($listing->id)) {
            // Remove
            Favorite::where('user_id', auth()->id())
                ->where('listing_id', $listing->id)
                ->delete();
            $favorited = false;
            $message = 'Removed from favorites';
        } else {
            // Add
            Favorite::create([
                'user_id' => auth()->id(),
                'listing_id' => $listing->id,
            ]);
            $favorited = true;
            $message = 'Added to favorites';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'favorited' => $favorited,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
