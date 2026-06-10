<!-- Navigation -->
<nav class="glass-nav sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2 shrink-0 group">
                <div class="w-9 h-9 gradient-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform floating">
                    <i class="fas fa-store text-white text-sm"></i>
                </div>
                <div>
                    <span class="font-bold text-xl text-white group-hover:gradient-text transition">Campus<span class="text-blue-500">Trade</span></span>
                    <span class="text-xs text-gray-500 block -mt-1">ETHIOPIA</span>
                </div>
            </a>
            
            <!-- Search -->
            <div class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="search-bar w-full flex items-center rounded-full px-4 py-2">
                    <i class="fas fa-search text-gray-500 mr-3"></i>
                    <input type="text" id="searchInput" placeholder="Search electronics, textbooks, furniture..." class="w-full outline-none bg-transparent text-white text-sm">
                    <button class="gradient-primary text-white px-5 py-1.5 rounded-full text-sm font-semibold ml-2 hover:scale-105 transition">Search</button>
                </div>
            </div>
            
            <!-- Nav Links -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('landing') }}" class="nav-link text-gray-300">Home</a>
                <a href="{{ route('listings.index') }}" class="nav-link text-gray-300">Marketplace</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link text-gray-300">Dashboard</a>
                    <a href="{{ route('messages.index') }}" class="nav-link text-gray-300 relative">
                        Messages
                        @php $unread = auth()->user()->unreadMessagesCount(); @endphp
                        @if($unread > 0)
                            <span class="absolute -top-2 -right-4 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">{{ $unread }}</span>
                        @endif
                    </a>
                    <a href="{{ route('favorites.index') }}" class="nav-link text-gray-300 relative">
                        <i class="fas fa-heart text-red-400"></i> Favorites
                        @php $favCount = auth()->user()->favoriteListings()->count(); @endphp
                        @if($favCount > 0)
                            <span class="absolute -top-2 -right-4 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">{{ $favCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('payment.history') }}" class="nav-link text-gray-300">Transactions</a>
                @endauth
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center text-white font-semibold text-sm group-hover:scale-110 transition">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform" :class="{'rotate-180': open}"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition duration-100 ease-out" x-transition:enter-start="transform scale-95 opacity-0" x-transition:enter-end="transform scale-100 opacity-100" class="absolute right-0 mt-2 w-56 bg-slate-800 rounded-xl shadow-2xl py-2 border border-slate-700 z-50" style="display: none;">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-slate-700">
                                <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <!-- Regular User Links -->
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                <i class="fas fa-user-circle w-4"></i> Profile
                            </a>
                            <a href="{{ route('listings.create') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                <i class="fas fa-plus-circle w-4 text-green-400"></i> Sell Item
                            </a>
                            <a href="{{ route('payment.history') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                <i class="fas fa-receipt w-4"></i> Transactions
                            </a>
                            
                            {{-- <!-- Admin Menu Section -->
                            @if(auth()->user()->is_admin)
                                <div class="px-3 py-2 mt-2 text-xs text-gray-500 border-t border-slate-700 uppercase tracking-wider">
                                    Admin Menu
                                </div>
                                
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-purple-400 hover:bg-purple-500/10 transition">
                                    <i class="fas fa-chart-line w-4"></i> Admin Dashboard
                                </a>
                                
                                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                    <i class="fas fa-users w-4"></i> User Management
                                </a>
                                
                                <a href="{{ route('admin.listings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                    <i class="fas fa-boxes w-4"></i> Listing Management
                                </a>
                                
                                <a href="{{ route('admin.payments') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-slate-700 transition">
                                    <i class="fas fa-credit-card w-4"></i> Payment Transactions
                                </a>
                                
                                <a href="{{ route('admin.ratings') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-yellow-400 hover:bg-yellow-500/10 transition">
                                    <i class="fas fa-star w-4"></i> Ratings Management
                                </a>
                                
                                <a href="{{ route('admin.top-sellers') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-green-400 hover:bg-green-500/10 transition">
                                    <i class="fas fa-trophy w-4"></i> Top Sellers
                                </a>
                            @endif --}}
                            
                            <div class="border-t border-slate-700 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 transition">
                                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-blue-400 transition">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary text-white px-5 py-2 rounded-full text-sm font-semibold">Sign Up</a>
                @endauth
                
                <button id="mobileMenuBtn" class="lg:hidden text-gray-400 text-xl hover:text-blue-400 transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search -->
        <div class="md:hidden py-3 border-t border-slate-700">
            <div class="search-bar w-full flex items-center rounded-full px-4 py-2">
                <i class="fas fa-search text-gray-500 mr-2"></i>
                <input type="text" placeholder="Search products..." class="w-full outline-none bg-transparent text-white text-sm">
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden py-4 border-t border-slate-700">
            <a href="{{ route('landing') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Home</a>
            <a href="{{ route('listings.index') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Marketplace</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Dashboard</a>
                <a href="{{ route('messages.index') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Messages</a>
                <a href="{{ route('favorites.index') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Favorites</a>
                <a href="{{ route('payment.history') }}" class="block py-2.5 text-gray-300 hover:text-blue-400 transition">Transactions</a>
                <a href="{{ route('listings.create') }}" class="block py-2.5 text-green-400 font-semibold">+ Sell Item</a>
                
                {{-- @if(auth()->user()->is_admin)
                    <div class="pt-2 mt-2 border-t border-slate-700">
                        <p class="text-xs text-gray-500 px-3 pb-2">ADMIN MENU</p>
                        <a href="{{ route('admin.dashboard') }}" class="block py-2.5 text-purple-400 hover:bg-purple-500/10 px-3 rounded-lg transition">📊 Admin Dashboard</a>
                        <a href="{{ route('admin.users') }}" class="block py-2.5 text-gray-300 hover:bg-slate-700 px-3 rounded-lg transition">👥 User Management</a>
                        <a href="{{ route('admin.listings') }}" class="block py-2.5 text-gray-300 hover:bg-slate-700 px-3 rounded-lg transition">📦 Listing Management</a>
                        <a href="{{ route('admin.payments') }}" class="block py-2.5 text-gray-300 hover:bg-slate-700 px-3 rounded-lg transition">💳 Payment Transactions</a>
                        <a href="{{ route('admin.ratings') }}" class="block py-2.5 text-yellow-400 hover:bg-yellow-500/10 px-3 rounded-lg transition">⭐ Ratings Management</a>
                        <a href="{{ route('admin.top-sellers') }}" class="block py-2.5 text-green-400 hover:bg-green-500/10 px-3 rounded-lg transition">🏆 Top Sellers</a>
                    </div>
                @endif --}}
            @else
                <a href="{{ route('login') }}" class="block py-2.5 text-gray-300">Login</a>
                <a href="{{ route('register') }}" class="block py-2.5 text-blue-400">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>