@extends('layouts.app-new')

@section('content')
<div class="bg-ju-offwhite min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" data-aos="fade-up">
            
            <!-- Image Gallery -->
            <div class="bg-white rounded-xl shadow-md border border-ju-border/50 p-6">
                <div class="space-y-4">
                    @if($listing->photos->isNotEmpty())
                        <div class="overflow-hidden rounded-xl bg-ju-surface">
                            <img id="mainImage" src="{{ $listing->photos->first()->photo_path }}" 
                                 class="w-full rounded-xl transition-transform duration-500 hover:scale-105"
                                 onerror="this.src='https://placehold.co/600x400/eef1f8/5a6480?text=No+Image'">
                        </div>
                        @if($listing->photos->count() > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($listing->photos as $photo)
                                    <img src="{{ $photo->photo_path }}" 
                                         onclick="document.getElementById('mainImage').src='{{ $photo->photo_path }}'"
                                         class="w-full h-24 object-cover rounded-lg cursor-pointer hover:ring-2 hover:ring-ju-navy transition"
                                         onerror="this.src='https://placehold.co/200x150/eef1f8/5a6480?text=No+Image'">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-96 bg-ju-surface rounded-xl flex flex-col items-center justify-center">
                            <i class="fas fa-image text-ju-muted text-6xl mb-3"></i>
                            <p class="text-ju-muted">No images available</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="bg-white rounded-xl shadow-md border border-ju-border/50 p-8">
                <h1 class="text-3xl font-bold text-ju-navy-dark mb-2">{{ $listing->title }}</h1>
                <p class="text-3xl font-bold text-ju-gold-dark mb-4">ETB {{ number_format($listing->price, 2) }}</p>
                
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-3 py-1 bg-ju-surface text-ju-navy rounded-full text-sm font-medium">{{ $listing->category }}</span>
                    <span class="px-3 py-1 bg-ju-surface text-ju-muted rounded-full text-sm">{{ $listing->condition }}</span>
                    @if($listing->status == 'Sold')
                        <span class="px-3 py-1 bg-ju-red/10 text-ju-red rounded-full text-sm font-semibold animate-pulse">SOLD</span>
                    @endif
                </div>
                
                <!-- Favorite Button -->
                @auth
                    @if(auth()->user()->hasFavorited($listing->id))
                        <form method="POST" action="{{ route('favorites.remove', $listing) }}" class="mb-6">
                            @csrf @method('DELETE')
                            <button class="w-full py-3 bg-ju-red/10 border border-ju-red text-ju-red rounded-xl font-semibold hover:bg-ju-red/20 transition flex items-center justify-center gap-2">
                                <i class="fas fa-heart"></i> Remove from Favorites
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorites.add', $listing) }}" class="mb-6">
                            @csrf
                            <button class="w-full py-3 bg-ju-surface border border-ju-border text-ju-navy rounded-xl font-semibold hover:bg-ju-navy/5 hover:border-ju-navy transition flex items-center justify-center gap-2">
                                <i class="far fa-heart"></i> Save to Favorites
                            </button>
                        </form>
                    @endif
                @endauth
                
                <!-- Description -->
                <div class="border-t border-ju-border pt-4 mb-4">
                    <h3 class="font-semibold text-ju-navy-dark mb-2 flex items-center gap-2">
                        <i class="fas fa-file-alt text-ju-gold"></i> Description
                    </h3>
                    <p class="text-ju-text leading-relaxed">{{ $listing->description }}</p>
                </div>
                
                <!-- Seller Info -->
                <div class="border-t border-ju-border pt-4 mb-6">
                    <h3 class="font-semibold text-ju-navy-dark mb-3 flex items-center gap-2">
                        <i class="fas fa-user-circle text-ju-gold"></i> Seller Information
                    </h3>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-ju-navy rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($listing->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-ju-navy-dark">{{ $listing->user->name }}</p>
                            <p class="text-sm text-ju-muted">Member since {{ $listing->user->created_at->format('M Y') }}</p>
                        </div>
                        @if($listing->user->is_verified_seller)
                            <span class="px-2 py-1 bg-ju-gold/10 text-ju-gold-dark rounded-full text-xs font-semibold flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Verified Seller
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                @if(auth()->check() && auth()->id() == $listing->user_id)
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('listings.edit', $listing) }}" class="flex-1 bg-ju-gold hover:bg-ju-gold-dark text-white py-3 rounded-xl font-semibold text-center transition flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('listings.destroy', $listing) }}" class="flex-1" onsubmit="return confirm('Delete this listing permanently?')">
                            @csrf @method('DELETE')
                            <button class="w-full bg-ju-red/10 border border-ju-red text-ju-red py-3 rounded-xl font-semibold hover:bg-ju-red/20 transition flex items-center justify-center gap-2">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                        @if($listing->status != 'Sold')
                            <form method="POST" action="{{ route('listings.markAsSold', $listing) }}" class="flex-1">
                                @csrf
                                <button class="w-full bg-ju-green/10 border border-ju-green text-ju-green py-3 rounded-xl font-semibold hover:bg-ju-green/20 transition flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Mark Sold
                                </button>
                            </form>
                        @endif
                    </div>
                @elseif(auth()->check())
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('messages.start', $listing) }}" class="flex-1 bg-ju-navy hover:bg-ju-navy-dark text-white py-3 rounded-xl font-semibold text-center transition flex items-center justify-center gap-2">
                            <i class="fas fa-comment"></i> Message Seller
                        </a>
                        @if($listing->status != 'Sold')
                            <a href="{{ route('payment.show', $listing) }}" class="flex-1 bg-ju-gold hover:bg-ju-gold-dark text-white py-3 rounded-xl font-semibold text-center transition flex items-center justify-center gap-2">
                                <i class="fas fa-credit-card"></i> Buy Now
                            </a>
                        @else
                            <button disabled class="flex-1 bg-ju-surface text-ju-muted py-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="fas fa-ban"></i> Sold Out
                            </button>
                        @endif
                    </div>

                    @php
                        $canRate = false;
                        $hasRated = false;
                        $paymentId = null;
                        
                        if (auth()->check() && auth()->id() != $listing->user_id) {
                            $payment = App\Models\Payment::where('buyer_id', auth()->id())
                                ->where('listing_id', $listing->id)
                                ->where('status', 'completed')
                                ->first();
                            
                            if ($payment) {
                                $canRate = true;
                                $paymentId = $payment->id;
                                $hasRated = App\Models\Rating::where('from_user_id', auth()->id())
                                    ->where('listing_id', $listing->id)
                                    ->exists();
                            }
                        }
                    @endphp

                    @if($canRate && !$hasRated && auth()->id() != $listing->user_id)
                        <div class="mt-4 p-4 bg-ju-gold/10 border border-ju-gold/30 rounded-xl">
                            <div class="flex justify-between items-center flex-wrap gap-3">
                                <div>
                                    <i class="fas fa-star text-ju-gold"></i>
                                    <span class="font-semibold text-ju-navy-dark ml-2">Rate this seller</span>
                                    <p class="text-sm text-ju-muted mt-1">Share your experience with {{ $listing->user->name }}</p>
                                </div>
                                <a href="{{ route('ratings.create', $paymentId) }}" class="bg-ju-gold hover:bg-ju-gold-dark text-white px-4 py-2 rounded-lg font-semibold transition">
                                    Write a Review <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
                
                <div class="border-t border-ju-border pt-4 mt-6 text-sm text-ju-muted">
                    <p><i class="fas fa-clock mr-1 text-ju-gold"></i> Posted {{ $listing->created_at->diffForHumans() }}</p>
                    <p class="mt-1"><i class="fas fa-eye mr-1 text-ju-gold"></i> {{ number_format($listing->views_count) }} views</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-ju-offwhite { background-color: #f4f6fb; }
    .bg-ju-navy { background-color: #003087; }
    .bg-ju-navy-dark { background-color: #001f5e; }
    .bg-ju-gold { background-color: #C8960C; }
    .bg-ju-gold-dark { background-color: #b07d0a; }
    .bg-ju-red { background-color: #c0392b; }
    .bg-ju-green { background-color: #2e7d32; }
    .bg-ju-surface { background-color: #eef1f8; }
    .text-ju-navy { color: #003087; }
    .text-ju-navy-dark { color: #001f5e; }
    .text-ju-gold { color: #C8960C; }
    .text-ju-gold-dark { color: #b07d0a; }
    .text-ju-muted { color: #5a6480; }
    .text-ju-red { color: #c0392b; }
    .text-ju-green { color: #2e7d32; }
    .border-ju-border { border-color: #c8d2e8; }
    
    .hover\:bg-ju-navy-dark:hover { background-color: #001f5e; }
    .hover\:bg-ju-gold-dark:hover { background-color: #b07d0a; }
    .hover\:bg-ju-red\/20:hover { background-color: rgba(192, 57, 43, 0.2); }
    .hover\:bg-ju-green\/20:hover { background-color: rgba(46, 125, 50, 0.2); }
    
    .animate-pulse {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>
@endsection