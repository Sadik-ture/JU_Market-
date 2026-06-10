@extends('layouts.app-new')

@section('content')

@if(auth()->user()->id_verification_status != 'approved')
    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-5 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white text-lg">Verification Required</h3>
                    <p class="text-gray-400 text-sm">You must verify your student ID to sell, buy, or message on Campus Trade.</p>
                </div>
            </div>
            <a href="{{ route('id-verification.show') }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-semibold transition whitespace-nowrap">
                Verify Now
            </a>
        </div>
    </div>
@endif

@if(auth()->user()->id_verification_status != 'approved')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-slate-800/50 rounded-xl p-4 opacity-50">
            <i class="fas fa-tag text-2xl text-gray-500 mb-2 block"></i>
            <h4 class="font-semibold text-white">Sell Items</h4>
            <p class="text-sm text-gray-500">🔒 Unlock after verification</p>
        </div>
        <div class="bg-slate-800/50 rounded-xl p-4 opacity-50">
            <i class="fas fa-comment text-2xl text-gray-500 mb-2 block"></i>
            <h4 class="font-semibold text-white">Message Sellers</h4>
            <p class="text-sm text-gray-500">🔒 Unlock after verification</p>
        </div>
        <div class="bg-slate-800/50 rounded-xl p-4 opacity-50">
            <i class="fas fa-shopping-cart text-2xl text-gray-500 mb-2 block"></i>
            <h4 class="font-semibold text-white">Buy Items</h4>
            <p class="text-sm text-gray-500">🔒 Unlock after verification</p>
        </div>
    </div>
@endif

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        
        <!-- Welcome Header with Live Clock -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4" data-aos="fade-up">
            <div>
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <p class="text-gray-400 mt-1">Welcome back, <span class="text-blue-400 font-semibold">{{ auth()->user()->name }}</span></p>
            </div>
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-xl px-6 py-3 border border-slate-700 text-center">
                <p class="text-xs text-gray-500">LIVE</p>
                <p class="text-xl font-bold text-white" id="liveClock">{{ now()->format('h:i:s A') }}</p>
                <p class="text-xs text-gray-500" id="liveDate">{{ now()->format('F j, Y') }}</p>
            </div>
        </div>
        
        <!-- Stats Cards with Click Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Users Card - Clickable -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700 hover:border-blue-500 transition-all cursor-pointer group transform hover:scale-105 duration-300" onclick="showUserModal()" data-aos="fade-up" data-aos-delay="0">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Users</p>
                        <p class="text-3xl font-bold text-white counter" data-target="{{ $stats['total_users'] }}">0</p>
                        <p class="text-xs text-green-400 mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +{{ number_format($stats['new_users_this_month']) }} this month</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center group-hover:bg-blue-500/30 transition">
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-700">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Active: <span class="text-green-400">{{ number_format($stats['active_users']) }}</span></span>
                        <span class="text-gray-500">Verified: <span class="text-blue-400">{{ number_format($stats['verified_sellers']) }}</span></span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-1.5 mt-2">
                        <div class="bg-green-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $stats['active_users_percentage'] }}%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Listings Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700 hover:border-green-500 transition-all cursor-pointer group transform hover:scale-105 duration-300" onclick="showListingModal()" data-aos="fade-up" data-aos-delay="50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Listings</p>
                        <p class="text-3xl font-bold text-white counter" data-target="{{ $stats['total_listings'] }}">0</p>
                        <p class="text-xs text-green-400 mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +{{ number_format($stats['new_listings_this_month']) }} new</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center group-hover:bg-green-500/30 transition">
                        <i class="fas fa-boxes text-green-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-700">
                    <div class="flex justify-between text-xs">
                        <span class="text-green-400">Active: {{ number_format($stats['active_listings']) }}</span>
                        <span class="text-yellow-400">Pending: {{ number_format($stats['pending_listings']) }}</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-1.5 mt-2">
                        <div class="bg-green-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $stats['total_listings'] > 0 ? ($stats['active_listings'] / $stats['total_listings'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Total Sales Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700 hover:border-purple-500 transition-all cursor-pointer group transform hover:scale-105 duration-300" onclick="showSalesModal()" data-aos="fade-up" data-aos-delay="100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Sales</p>
                        <p class="text-3xl font-bold text-white counter" data-target="{{ $stats['total_sales'] }}">0</p>
                        <p class="text-xs text-green-400 mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +{{ number_format($stats['sales_this_month']) }} this month</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center group-hover:bg-purple-500/30 transition">
                        <i class="fas fa-shopping-cart text-purple-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-700">
                    <div class="flex justify-between text-xs">
                        <span class="text-green-400">Completed: {{ number_format($stats['completed_payments']) }}</span>
                        <span class="text-yellow-400">Pending: {{ number_format($stats['pending_payments']) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Revenue Card -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-5 border border-slate-700 hover:border-yellow-500 transition-all cursor-pointer group transform hover:scale-105 duration-300" onclick="showRevenueModal()" data-aos="fade-up" data-aos-delay="150">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Total Revenue</p>
                        <p class="text-3xl font-bold text-white counter" data-target="{{ $stats['revenue'] }}">0</p>
                        <p class="text-xs text-green-400 mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +ETB {{ number_format($stats['revenue_this_month'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center group-hover:bg-yellow-500/30 transition">
                        <i class="fas fa-credit-card text-yellow-400 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-slate-700">
                    <div class="text-center text-xs">
                        <span class="text-gray-500">Avg Order: ETB {{ number_format($stats['average_order_value'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Interactive Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sales Chart with Range Filter -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700" data-aos="fade-up">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                    <h3 class="text-lg font-semibold text-white">Sales Overview</h3>
                    <div class="flex gap-2">
                        <button class="range-btn px-3 py-1 rounded-lg text-xs font-semibold transition" data-days="7" style="background: #3B82F6; color: white;">7D</button>
                        <button class="range-btn px-3 py-1 rounded-lg text-xs font-semibold transition bg-slate-700 text-gray-300 hover:bg-slate-600" data-days="30">30D</button>
                        <button class="range-btn px-3 py-1 rounded-lg text-xs font-semibold transition bg-slate-700 text-gray-300 hover:bg-slate-600" data-days="90">90D</button>
                    </div>
                </div>
                <canvas id="salesChart" height="250" style="cursor: pointer;" onclick="alert('Click on chart for detailed report')"></canvas>
                <div class="mt-3 text-center">
                    <span class="text-xs text-gray-500">📊 Click on chart for detailed analytics</span>
                </div>
            </div>
            
            <!-- Revenue Chart -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700" data-aos="fade-up" data-aos-delay="100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-white">Revenue Trend</h3>
                    <span class="text-xs text-gray-500">ETB (Ethiopian Birr)</span>
                </div>
                <canvas id="revenueChart" height="250" style="cursor: pointer;" onclick="alert('Total Revenue: ETB {{ number_format($stats['revenue'], 2) }}')"></canvas>
            </div>
        </div>
        
        <!-- Interactive Stats Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Category Distribution - Clickable Segments -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700" data-aos="fade-up">
                <h3 class="text-lg font-semibold text-white mb-4">Listings by Category</h3>
                <div class="relative">
                    <canvas id="categoryChart" height="200" style="cursor: pointer;"></canvas>
                </div>
                <div class="mt-4 space-y-2" id="categoryLegend"></div>
                <div class="mt-3 text-center text-xs text-gray-500">📊 Click on segments to filter listings</div>
            </div>
            
            <!-- Payment Status - Interactive -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700" data-aos="fade-up" data-aos-delay="50">
                <h3 class="text-lg font-semibold text-white mb-4">Payment Status</h3>
                <canvas id="paymentStatusChart" height="200" style="cursor: pointer;" onclick="showPaymentDetails()"></canvas>
                <div class="mt-4 text-center">
                    <div class="inline-flex items-center gap-2 bg-slate-700/50 rounded-full px-4 py-2">
                        <i class="fas fa-chart-line text-green-400"></i>
                        <p class="text-sm text-gray-300">Success Rate: <span class="text-green-400 font-bold">{{ number_format($stats['payment_success_rate'], 1) }}%</span></p>
                    </div>
                </div>
                <div class="mt-3 text-center text-xs text-gray-500">💰 Click on chart for transaction details</div>
            </div>
            
            <!-- User Activity with Interactive Progress -->
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-lg font-semibold text-white mb-4">Platform Health</h3>
                <div class="space-y-5">
                    <div class="group cursor-pointer" onclick="showUserDetails('active')">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-400 flex items-center gap-2"><i class="fas fa-circle text-green-500 text-xs"></i> Active Users</span>
                            <span class="text-white font-semibold">{{ number_format($stats['active_users_percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full progress-bar transition-all duration-1000" style="width: {{ $stats['active_users_percentage'] }}%"></div>
                        </div>
                    </div>
                    <div class="group cursor-pointer" onclick="showUserDetails('verified')">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-400 flex items-center gap-2"><i class="fas fa-check-circle text-blue-500 text-xs"></i> Verified Sellers</span>
                            <span class="text-white font-semibold">{{ number_format($stats['verified_sellers_percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full progress-bar transition-all duration-1000" style="width: {{ $stats['verified_sellers_percentage'] }}%"></div>
                        </div>
                    </div>
                    <div class="group cursor-pointer" onclick="showImageDetails()">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-400 flex items-center gap-2"><i class="fas fa-image text-purple-500 text-xs"></i> Listings with Images</span>
                            <span class="text-white font-semibold">{{ number_format($stats['listings_with_images_percentage'], 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-purple-500 h-3 rounded-full progress-bar transition-all duration-1000" style="width: {{ $stats['listings_with_images_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-slate-700">
                    <div class="flex justify-between text-sm">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">{{ number_format($stats['completed_payments']) }}</p>
                            <p class="text-xs text-gray-500">Completed Payments</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">{{ number_format($stats['pending_payments']) }}</p>
                            <p class="text-xs text-gray-500">Pending Payments</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-white">{{ number_format($stats['failed_payments']) }}</p>
                            <p class="text-xs text-gray-500">Failed Payments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity Tabs -->
        <div class="mb-6" data-aos="fade-up">
            <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700">
                <div class="border-b border-slate-700">
                    <div class="flex">
                        <button class="tab-btn px-6 py-3 text-sm font-semibold transition-all" data-tab="users" style="border-bottom: 2px solid #3B82F6; color: #3B82F6;">
                            <i class="fas fa-users mr-2"></i> Recent Users
                        </button>
                        <button class="tab-btn px-6 py-3 text-sm font-semibold text-gray-400 hover:text-white transition-all" data-tab="listings">
                            <i class="fas fa-boxes mr-2"></i> Recent Listings
                        </button>
                        <button class="tab-btn px-6 py-3 text-sm font-semibold text-gray-400 hover:text-white transition-all" data-tab="payments">
                            <i class="fas fa-credit-card mr-2"></i> Recent Payments
                        </button>
                    </div>
                </div>
                
                <!-- Users Tab -->
                <div id="users-tab" class="tab-content divide-y divide-slate-700">
                    @foreach($recent_users as $user)
                    <div class="px-6 py-3 flex items-center justify-between hover:bg-slate-700/30 transition cursor-pointer" onclick="viewUser({{ $user->id }})">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            @if($user->is_verified_seller)
                                <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                            @endif
                            <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                            <i class="fas fa-chevron-right text-gray-600 text-sm"></i>
                        </div>
                    </div>
                    @endforeach
                    <div class="px-6 py-3 border-t border-slate-700 text-center">
                        <a href="{{ route('admin.users') }}" class="text-blue-400 text-sm hover:underline">View All Users →</a>
                    </div>
                </div>
                
                <!-- Listings Tab -->
                <div id="listings-tab" class="tab-content divide-y divide-slate-700 hidden">
                    @foreach($recent_listings as $listing)
                    <div class="px-6 py-3 flex items-center justify-between hover:bg-slate-700/30 transition cursor-pointer" onclick="viewListing({{ $listing->id }})">
                        <div class="flex items-center gap-3">
                            @if($listing->photos->first())
                                <img src="{{ $listing->photos->first()->photo_path }}" class="w-10 h-10 object-cover rounded-lg">
                            @else
                                <div class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-500"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-white">{{ Str::limit($listing->title, 30) }}</p>
                                <p class="text-xs text-gray-500">By {{ $listing->user->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-blue-400">ETB {{ number_format($listing->price, 2) }}</p>
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($listing->status == 'Active') bg-green-500/20 text-green-400
                                @elseif($listing->status == 'Sold') bg-gray-500/20 text-gray-400
                                @else bg-yellow-500/20 text-yellow-400
                                @endif">
                                {{ $listing->status }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                    <div class="px-6 py-3 border-t border-slate-700 text-center">
                        <a href="{{ route('admin.listings') }}" class="text-blue-400 text-sm hover:underline">View All Listings →</a>
                    </div>
                </div>
                
                <!-- Payments Tab -->
                <div id="payments-tab" class="tab-content divide-y divide-slate-700 hidden">
                    @php
                        $recent_payments = App\Models\Payment::with(['buyer', 'seller', 'listing'])->latest()->limit(10)->get();
                    @endphp
                    @foreach($recent_payments as $payment)
                    <div class="px-6 py-3 flex items-center justify-between hover:bg-slate-700/30 transition cursor-pointer" onclick="viewPayment({{ $payment->id }})">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-receipt text-purple-400"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white">{{ Str::limit($payment->listing->title ?? 'N/A', 25) }}</p>
                                <p class="text-xs text-gray-500">Buyer: {{ $payment->buyer->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-green-400">ETB {{ number_format($payment->amount, 2) }}</p>
                            <span class="text-xs px-2 py-1 rounded-full 
                                @if($payment->status == 'completed') bg-green-500/20 text-green-400
                                @elseif($payment->status == 'pending') bg-yellow-500/20 text-yellow-400
                                @else bg-red-500/20 text-red-400
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Top Sellers Table with Animation -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700" data-aos="fade-up">
            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i> Top Performing Sellers
                </h3>
                <span class="text-xs text-gray-500">🏆 Based on revenue</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300">#</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300">Seller</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-300">Items Sold</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-300">Revenue</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-300">Rating</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @foreach($top_sellers as $index => $seller)
                        <tr class="hover:bg-slate-700/30 transition cursor-pointer" onclick="viewSeller({{ $loop->index }})">
                            <td class="px-6 py-3">
                                @if($index == 0)
                                    <span class="text-2xl">🥇</span>
                                @elseif($index == 1)
                                    <span class="text-2xl">🥈</span>
                                @elseif($index == 2)
                                    <span class="text-2xl">🥉</span>
                                @else
                                    <span class="text-white font-bold">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center text-white text-sm">
                                        {{ substr($seller['name'], 0, 1) }}
                                    </div>
                                    <span class="text-white font-medium">{{ $seller['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-center text-white">{{ number_format($seller['items_sold']) }}</td>
                            <td class="px-6 py-3 text-center text-green-400 font-semibold">ETB {{ number_format($seller['revenue'], 2) }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    <span class="text-white">{{ number_format($seller['rating'], 1) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <button class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-xs hover:bg-blue-500/30 transition" onclick="event.stopPropagation(); viewSellerDetails({{ $index }})">
                                    View Profile
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Refresh Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <button onclick="refreshDashboard()" class="bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110 group">
                <i class="fas fa-sync-alt text-xl group-hover:rotate-180 transition-transform duration-500"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal for User Details -->
<div id="userModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center" onclick="closeModal()">
    <div class="bg-slate-800 rounded-2xl max-w-md w-full mx-4 p-6 border border-slate-700" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">User Statistics</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white">&times;</button>
        </div>
        <div id="modalContent"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleTimeString('en-US');
    }
    setInterval(updateClock, 1000);
    
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        let current = 0;
        const increment = target / 50;
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.innerText = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        updateCounter();
    });
    
    // Progress Bar Animation
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => { bar.style.width = width; }, 100);
    });
    
    // Tab Switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = this.getAttribute('data-tab');
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.style.borderBottom = 'none';
                b.style.color = '#9CA3AF';
            });
            this.style.borderBottom = '2px solid #3B82F6';
            this.style.color = '#3B82F6';
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById(`${tab}-tab`).classList.remove('hidden');
        });
    });
    
    // Range Filter for Charts
    let salesChart, revenueChart;
    
    function updateCharts(days) {
        fetch(`/admin/chart-data/${days}`)
            .then(res => res.json())
            .then(data => {
                if (salesChart) salesChart.destroy();
                if (revenueChart) revenueChart.destroy();
                initCharts(data.sales_labels, data.sales_data, data.revenue_labels, data.revenue_data);
            });
    }
    
    document.querySelectorAll('.range-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.range-btn').forEach(b => {
                b.style.background = '#334155';
                b.style.color = '#9CA3AF';
            });
            this.style.background = '#3B82F6';
            this.style.color = 'white';
            updateCharts(this.getAttribute('data-days'));
        });
    });
    
    // Initialize Charts
    function initCharts(salesLabels, salesData, revenueLabels, revenueData) {
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Sales',
                    data: salesData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { labels: { color: '#9CA3AF' } } },
                scales: { y: { grid: { color: '#1E293B' }, ticks: { color: '#9CA3AF' } }, x: { grid: { color: '#1E293B' }, ticks: { color: '#9CA3AF' } } }
            }
        });
        
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue (ETB)',
                    data: revenueData,
                    backgroundColor: '#10B981',
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { labels: { color: '#9CA3AF' } } },
                scales: { y: { grid: { color: '#1E293B' }, ticks: { color: '#9CA3AF' } }, x: { grid: { color: '#1E293B' }, ticks: { color: '#9CA3AF' } } }
            }
        });
    }
    
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($category_labels) !!},
            datasets: [{
                data: {!! json_encode($category_data) !!},
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#9CA3AF' } } },
            onClick: (e, activeEls) => {
                if (activeEls.length > 0) {
                    const index = activeEls[0].index;
                    const category = {!! json_encode($category_labels) !!}[index];
                    window.location.href = `/admin/listings?category=${category}`;
                }
            }
        }
    });
    
    // Payment Status Chart
    const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending', 'Failed'],
            datasets: [{
                data: [{{ $stats['completed_payments'] }}, {{ $stats['pending_payments'] }}, {{ $stats['failed_payments'] }}],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#9CA3AF' } } },
            onClick: () => window.location.href = '/admin/payments'
        }
    });
    
    // Modal Functions
    function showUserModal() { showModal('Total Users: {{ number_format($stats['total_users']) }}\nActive: {{ number_format($stats['active_users']) }}\nVerified: {{ number_format($stats['verified_sellers']) }}'); }
    function showListingModal() { showModal('Total Listings: {{ number_format($stats['total_listings']) }}\nActive: {{ number_format($stats['active_listings']) }}\nSold: {{ number_format($stats['sold_listings']) }}'); }
    function showSalesModal() { showModal('Total Sales: {{ number_format($stats['total_sales']) }}\nThis Month: {{ number_format($stats['sales_this_month']) }}\nSuccess Rate: {{ number_format($stats['payment_success_rate'], 1) }}%'); }
    function showRevenueModal() { showModal('Total Revenue: ETB {{ number_format($stats['revenue'], 2) }}\nThis Month: ETB {{ number_format($stats['revenue_this_month'], 2) }}\nAvg Order: ETB {{ number_format($stats['average_order_value'], 2) }}'); }
    function showPaymentDetails() { window.location.href = '/admin/payments'; }
    function showUserDetails(type) { showModal(type === 'active' ? 'Active Users: {{ number_format($stats['active_users']) }}\nPercentage: {{ number_format($stats['active_users_percentage'], 1) }}%' : 'Verified Sellers: {{ number_format($stats['verified_sellers']) }}\nPercentage: {{ number_format($stats['verified_sellers_percentage'], 1) }}%'); }
    function showImageDetails() { showModal('Listings with Images: {{ number_format($stats['listings_with_images']) }}\nPercentage: {{ number_format($stats['listings_with_images_percentage'], 1) }}%'); }
    
    function showModal(message) {
        document.getElementById('modalContent').innerHTML = `<p class="text-gray-300">${message.replace(/\n/g, '<br>')}</p>`;
        document.getElementById('userModal').classList.remove('hidden');
        document.getElementById('userModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.getElementById('userModal').style.display = 'none';
    }
    
    function viewUser(id) { window.location.href = `/admin/users?search=${id}`; }
    function viewListing(id) { window.location.href = `/listings/${id}`; }
    function viewPayment(id) { window.location.href = `/admin/payments`; }
    function viewSeller(index) { showModal(`Top Seller #${index + 1}\nCheck admin panel for details`); }
    function viewSellerDetails(index) { showModal(`Seller Profile - Top ${index + 1}\nFull details in user management`); }
    
    function refreshDashboard() { location.reload(); }
    
    // Initial charts with PHP data
    initCharts({!! json_encode($sales_labels) !!}, {!! json_encode($sales_data) !!}, {!! json_encode($revenue_labels) !!}, {!! json_encode($revenue_data) !!});
</script>
@endsection


