<div class="hero-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Buy & Sell<br>
                    <span class="text-indigo-400">On Campus</span> With Confidence
                </h1>
                <p class="text-gray-300 text-lg mb-8">
                    The trusted marketplace exclusively for university students. 
                    Sell your used items, find great deals, and connect with fellow students.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('listings.index') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-shopping-bag mr-2"></i> Start Shopping
                    </a>
                    @guest
                        <a href="{{ route('register') }}" 
                           class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-lg font-semibold transition border border-white/20">
                            <i class="fas fa-user-plus mr-2"></i> Join Campus Trade
                        </a>
                    @endguest
                </div>
                
                <!-- Stats -->
                <div class="flex gap-8 mt-8 pt-8 border-t border-white/20">
                    <div>
                        <div class="text-2xl font-bold text-indigo-400">500+</div>
                        <div class="text-sm text-gray-300">Active Students</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-indigo-400">1000+</div>
                        <div class="text-sm text-gray-300">Items Sold</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-indigo-400">10+</div>
                        <div class="text-sm text-gray-300">Universities</div>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-2xl p-8 backdrop-blur-sm">
                    <i class="fas fa-graduation-cap text-7xl text-indigo-400 mb-4 block"></i>
                    <h3 class="text-xl font-bold mb-2">Why Campus Trade?</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Only verified university emails</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Campus-specific listings</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Secure Chapa payments</li>
                        <li><i class="fas fa-check-circle text-green-400 mr-2"></i> Real-time messaging</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>