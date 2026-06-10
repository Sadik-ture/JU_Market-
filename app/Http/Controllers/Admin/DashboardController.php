<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeNotification;
use App\Models\Listing;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        // ========== USER STATS ==========
        $total_users = User::count();
        $active_users = User::where('last_seen_at', '>=', $now->copy()->subDays(7))->count();
        $verified_sellers = User::where('is_verified_seller', true)->count();
        $new_users_this_month = User::where('created_at', '>=', $startOfMonth)->count();

        // ========== LISTING STATS ==========
        $total_listings = Listing::count();
        $active_listings = Listing::where('status', 'Active')->count();
        $sold_listings = Listing::where('status', 'Sold')->count();
        $pending_listings = Listing::where('status', 'Draft')->count();
        $listings_with_images = Listing::has('photos')->count();
        $new_listings_this_month = Listing::where('created_at', '>=', $startOfMonth)->count();

        // ========== PAYMENT STATS ==========
        $completed_payments = Payment::where('status', 'completed')->count();
        $pending_payments = Payment::where('status', 'pending')->count();
        $failed_payments = Payment::where('status', 'failed')->count();
        $total_sales = $completed_payments;
        $revenue = Payment::where('status', 'completed')->sum('amount');
        $sales_this_month = Payment::where('status', 'completed')->where('created_at', '>=', $startOfMonth)->count();
        $revenue_this_month = Payment::where('status', 'completed')->where('created_at', '>=', $startOfMonth)->sum('amount');
        $average_order_value = $completed_payments > 0 ? $revenue / $completed_payments : 0;
        $payment_success_rate = ($total_sales + $pending_payments + $failed_payments) > 0
            ? ($completed_payments / ($total_sales + $pending_payments + $failed_payments)) * 100
            : 0;

        // ========== PERCENTAGES ==========
        $active_users_percentage = $total_users > 0 ? ($active_users / $total_users) * 100 : 0;
        $verified_sellers_percentage = $total_users > 0 ? ($verified_sellers / $total_users) * 100 : 0;
        $listings_with_images_percentage = $total_listings > 0 ? ($listings_with_images / $total_listings) * 100 : 0;

        // ========== CATEGORY DISTRIBUTION ==========
        $categories = ['Electronics', 'Textbooks', 'Furniture', 'Clothing', 'Vehicles', 'Miscellaneous'];
        $category_labels = [];
        $category_data = [];
        foreach ($categories as $category) {
            $count = Listing::where('category', $category)->count();
            if ($count > 0) {
                $category_labels[] = $category;
                $category_data[] = $count;
            }
        }

        // ========== SALES & REVENUE CHART DATA (Last 30 days) ==========
        $sales_labels = [];
        $sales_data = [];
        $revenue_labels = [];
        $revenue_data = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $sales_labels[] = $date->format('M d');
            $sales_data[] = Payment::where('status', 'completed')
                ->whereDate('created_at', $date->toDateString())
                ->count();
            $revenue_labels[] = $date->format('M d');
            $revenue_data[] = (float) Payment::where('status', 'completed')
                ->whereDate('created_at', $date->toDateString())
                ->sum('amount');
        }

        // ========== TOP SELLERS (Simplified) ==========
        $top_sellers = [];
        $sellerData = DB::table('payments')
            ->join('users', 'payments.seller_id', '=', 'users.id')
            ->where('payments.status', 'completed')
            ->select('users.id', 'users.name', 'users.rating_avg')
            ->selectRaw('COUNT(payments.id) as items_sold')
            ->selectRaw('SUM(payments.amount) as revenue')
            ->groupBy('users.id', 'users.name', 'users.rating_avg')
            ->orderBy('revenue', 'desc')
            ->limit(5)
            ->get();

        foreach ($sellerData as $seller) {
            $top_sellers[] = [
                'name' => $seller->name,
                'items_sold' => $seller->items_sold,
                'revenue' => $seller->revenue,
                'rating' => $seller->rating_avg ?? 0,
            ];
        }

        // ========== STATS ARRAY ==========
        $stats = [
            'total_users' => $total_users,
            'active_users' => $active_users,
            'verified_sellers' => $verified_sellers,
            'new_users_this_month' => $new_users_this_month,
            'total_listings' => $total_listings,
            'active_listings' => $active_listings,
            'sold_listings' => $sold_listings,
            'pending_listings' => $pending_listings,
            'new_listings_this_month' => $new_listings_this_month,
            'listings_with_images' => $listings_with_images,
            'total_sales' => $total_sales,
            'completed_payments' => $completed_payments,
            'pending_payments' => $pending_payments,
            'failed_payments' => $failed_payments,
            'revenue' => $revenue,
            'sales_this_month' => $sales_this_month,
            'revenue_this_month' => $revenue_this_month,
            'average_order_value' => $average_order_value,
            'payment_success_rate' => $payment_success_rate,
            'active_users_percentage' => $active_users_percentage,
            'verified_sellers_percentage' => $verified_sellers_percentage,
            'listings_with_images_percentage' => $listings_with_images_percentage,
        ];

        // ========== RECENT DATA ==========
        $recent_users = User::latest()->limit(10)->get();
        $recent_listings = Listing::with('user', 'photos')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_listings',
            'sales_labels',
            'sales_data',
            'revenue_labels',
            'revenue_data',
            'category_labels',
            'category_data',
            'top_sellers'
        ));
    }

    public function chartData($days)
    {
        $now = Carbon::now();
        $sales_labels = [];
        $sales_data = [];
        $revenue_labels = [];
        $revenue_data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $sales_labels[] = $date->format('M d');
            $sales_data[] = Payment::where('status', 'completed')->whereDate('created_at', $date->toDateString())->count();
            $revenue_labels[] = $date->format('M d');
            $revenue_data[] = (float) Payment::where('status', 'completed')->whereDate('created_at', $date->toDateString())->sum('amount');
        }

        return response()->json([
            'sales_labels' => $sales_labels,
            'sales_data' => $sales_data,
            'revenue_labels' => $revenue_labels,
            'revenue_data' => $revenue_data,
        ]);
    }

    public function testEmail()
    {
        Mail::to(auth()->user()->email)->send(new WelcomeNotification(auth()->user()));

        return back()->with('success', 'Test email sent!');
    }
}
