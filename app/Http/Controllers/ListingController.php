<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::active()->with('user', 'photos');

        if (auth()->check()) {
            $query->where('campus', auth()->user()->university_domain);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $listings = $query->latest()->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('listings.partials.grid', compact('listings'))->render(),
                'pagination' => view('pagination::bootstrap-4', ['paginator' => $listings])->render(),
            ]);
        }

        return view('listings.index', compact('listings'));
    }

    // Display all listings
    // public function index(Request $request)
    // {
    //     $query = Listing::active()->with('user', 'photos');

    //     // Filter by campus (only show items from same university)
    //     if (auth()->check()) {
    //         $query->where('campus', auth()->user()->university_domain);
    //     }

    //     // Category filter
    //     if ($request->filled('category')) {
    //         $query->where('category', $request->category);
    //     }

    //     // Price range filter
    //     if ($request->filled('min_price')) {
    //         $query->where('price', '>=', $request->min_price);
    //     }
    //     if ($request->filled('max_price')) {
    //         $query->where('price', '<=', $request->max_price);
    //     }

    //     // Search
    //     if ($request->filled('search')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('title', 'like', '%'.$request->search.'%')
    //                 ->orWhere('description', 'like', '%'.$request->search.'%');
    //         });
    //     }

    //     $listings = $query->latest()->paginate(20);

    //     return view('listings.index', compact('listings'));
    // }

    // Show create listing form
    public function create()
    {
        return view('listings.create');
    }

    // Store new listing
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category' => 'required|in:Electronics,Textbooks,Furniture,Clothing,Vehicles,Miscellaneous',
            'condition' => 'required|in:New,Like New,Good,Fair',
            'photos' => 'required|array|min:1|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Create listing
        $listing = Listing::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category' => $validated['category'],
            'condition' => $validated['condition'],
            'campus' => auth()->user()->university_domain,
            'expires_at' => now()->addDays(30),
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                // Store original image
                $path = $photo->store('listings', 'public');
                $fullPath = Storage::url($path);

                ListingPhoto::create([
                    'listing_id' => $listing->id,
                    'photo_path' => $fullPath,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Your item has been listed successfully!');
    }

    // Show single listing
    public function show(Listing $listing)
    {
        // Increment view count
        $listing->increment('views_count');

        return view('listings.show', compact('listing'));
    }

    // Show edit form
    public function edit(Listing $listing)
    {
        // Only seller can edit
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('listings.edit', compact('listing'));
    }

    // Update listing
    public function update(Request $request, Listing $listing)
    {
        // Only seller can update
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Electronics,Textbooks,Furniture,Clothing,Vehicles,Miscellaneous',
            'condition' => 'required|in:New,Like New,Good,Fair',
        ]);

        $listing->update($validated);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    // Delete listing (soft delete)
    public function destroy(Listing $listing)
    {
        // Only seller can delete
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized');
        }

        $listing->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Listing deleted successfully');
    }

    // Mark as sold
    public function markAsSold(Listing $listing)
    {
        // Only seller can mark as sold
        if (auth()->id() !== $listing->user_id) {
            abort(403, 'Unauthorized');
        }

        $listing->update(['status' => 'Sold']);

        return back()->with('success', 'Item marked as sold');
    }

    public function toggleFavorite(Listing $listing)
    {
        $user = auth()->user();

        if ($user->hasFavorited($listing->id)) {
            \DB::table('favorites')
                ->where('user_id', $user->id)
                ->where('listing_id', $listing->id)
                ->delete();
            $favorited = false;
        } else {
            \DB::table('favorites')->insert([
                'user_id' => $user->id,
                'listing_id' => $listing->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $favorited = true;
        }

        return response()->json(['favorited' => $favorited]);
    }
}
