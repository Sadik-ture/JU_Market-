<div class="gradient-bg py-16">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Ready to Start Trading?
        </h2>
        <p class="text-indigo-100 text-lg mb-8">
            Join hundreds of students already using Campus Trade
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            @auth
                <a href="{{ route('listings.create') }}" 
                   class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-plus-circle mr-2"></i> Sell an Item
                </a>
                <a href="{{ route('listings.index') }}" 
                   class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition">
                    <i class="fas fa-shopping-bag mr-2"></i> Browse Items
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-user-plus mr-2"></i> Create Free Account
                </a>
                <a href="{{ route('listings.index') }}" 
                   class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition">
                    <i class="fas fa-eye mr-2"></i> Browse as Guest
                </a>
            @endauth
        </div>
    </div>
</div>