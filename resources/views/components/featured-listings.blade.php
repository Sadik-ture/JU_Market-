<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">🔥 Featured Listings</h2>
                <p class="text-gray-600 mt-1">Popular items from your campus community</p>
            </div>
            <a href="{{ route('listings.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        @if($listings->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($listings as $listing)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all hover-scale">
                        <a href="{{ route('listings.show', $listing) }}">
                            @if($listing->photos->first())
                                <img src="{{ $listing->photos->first()->photo_path }}" 
                                     alt="{{ $listing->title }}"
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <a href="{{ route('listings.show', $listing) }}">
                                <h3 class="font-semibold text-gray-800 hover:text-indigo-600 transition">
                                    {{ Str::limit($listing->title, 40) }}
                                </h3>
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-user mr-1"></i> {{ $listing->user->name }}
                            </p>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-xl font-bold text-green-600">
                                    ETB {{ number_format($listing->price, 2) }}
                                </span>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                    {{ $listing->condition }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl">
                <i class="fas fa-box-open text-gray-400 text-5xl mb-3"></i>
                <p class="text-gray-500">No listings yet. Be the first to sell something!</p>
                <a href="{{ route('listings.create') }}" class="inline-block mt-4 text-indigo-600 hover:underline">
                    Create a Listing →
                </a>
            </div>
        @endif
    </div>
</div>