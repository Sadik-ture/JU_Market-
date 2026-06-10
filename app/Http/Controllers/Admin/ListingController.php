<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with('user');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $listings = $query->latest()->paginate(20);
        $categories = ['Electronics', 'Textbooks', 'Furniture', 'Clothing', 'Vehicles', 'Miscellaneous'];
        $statuses = ['Active', 'Sold', 'Expired', 'Draft', 'Archived'];

        return view('admin.listings', compact('listings', 'categories', 'statuses'));
    }

    public function updateStatus(Listing $listing, Request $request)
    {
        $request->validate([
            'status' => 'required|in:Active,Sold,Expired,Draft,Archived',
        ]);

        $listing->update(['status' => $request->status]);

        return back()->with('success', 'Listing status updated to '.$request->status);
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return back()->with('success', 'Listing deleted successfully.');
    }
}
