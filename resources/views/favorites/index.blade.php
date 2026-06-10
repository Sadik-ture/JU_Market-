@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#003087]/10 rounded-full mb-4">
                <i class="fas fa-heart text-[#C8960C] text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#001f5e]">My Favorites</h2>
            <p class="text-[#5a6480] mt-1">Items you've saved for later</p>
        </div>
        
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $listing)
                    <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden transition hover:shadow-md group">
                        <!-- Image Container -->
                        <div class="relative h-48 overflow-hidden bg-[#eef1f8]">
                            @if($listing->photos->first())
                                <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                     src="{{ $listing->photos->first()->photo_path }}" 
                                     alt="{{ $listing->title }}"
                                     onerror="this.src='https://placehold.co/400x300/eef1f8/5a6480?text=No+Image'">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center">
                                    <i class="fas fa-image text-[#5a6480] text-4xl mb-2"></i>
                                    <span class="text-[#5a6480] text-sm">No Image</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-[#001f5e] text-lg mb-1 line-clamp-1">{{ Str::limit($listing->title, 35) }}</h3>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs bg-[#eef1f8] text-[#5a6480] px-2 py-0.5 rounded-full">{{ $listing->category }}</span>
                                <span class="text-xs bg-[#eef1f8] text-[#5a6480] px-2 py-0.5 rounded-full">{{ $listing->condition }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xl font-bold text-[#003087]">ETB {{ number_format($listing->price, 2) }}</span>
                                <i class="fas fa-heart text-[#c0392b] text-lg"></i>
                            </div>
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('listings.show', $listing) }}" class="flex-1 bg-[#003087]/10 hover:bg-[#003087]/20 text-[#003087] py-2 rounded-lg text-center text-sm font-semibold transition flex items-center justify-center gap-1">
                                    <i class="fas fa-eye text-xs"></i> View Details
                                </a>
                                <form method="POST" action="{{ route('favorites.remove', $listing) }}" class="inline" onsubmit="return confirm('Remove this item from favorites?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-4 py-2 rounded-lg transition flex items-center justify-center" title="Remove from Favorites">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $favorites->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-[#eef1f8] rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-heart-broken text-[#5a6480] text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-[#001f5e] mb-2">No favorites yet</h3>
                    <p class="text-[#5a6480] mb-6">You haven't saved any items to your favorites list.</p>
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition">
                        <i class="fas fa-store"></i> Browse Marketplace
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection