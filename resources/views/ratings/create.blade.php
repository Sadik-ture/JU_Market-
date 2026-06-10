@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full">
        
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Header -->
            <div class="bg-[#eef1f8] border-b border-[#c8d2e8] px-6 py-5 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#003087]/10 rounded-full mb-3">
                    <i class="fas fa-star text-[#C8960C] text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-[#001f5e]">Rate Your Experience</h2>
                <p class="text-[#5a6480] text-sm mt-1">How was your transaction with <span class="font-semibold text-[#003087]">{{ $payment->seller->name }}</span>?</p>
            </div>
            
            <!-- Form Body -->
            <div class="p-6">
                <form method="POST" action="{{ route('ratings.store', $payment) }}">
                    @csrf

                    <!-- Rating Stars Section -->
                    <div class="mb-8 text-center">
                        <label class="block text-sm font-medium text-[#001f5e] mb-3">Your Rating <span class="text-[#c0392b]">*</span></label>
                        <div class="flex justify-center gap-3" id="ratingStars">
                            <i class="far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]" data-value="1"></i>
                            <i class="far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]" data-value="2"></i>
                            <i class="far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]" data-value="3"></i>
                            <i class="far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]" data-value="4"></i>
                            <i class="far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" required>
                        @error('rating') 
                            <p class="mt-2 text-sm text-[#c0392b] flex items-center justify-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-[#5a6480] mt-2">Click on a star to rate</p>
                    </div>

                    <!-- Review Text Section -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-[#001f5e] mb-2">
                            <i class="fas fa-pen text-[#C8960C] text-xs mr-1"></i> Write a Review (Optional)
                        </label>
                        <textarea name="review" rows="4" 
                                  class="w-full px-4 py-3 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition resize-none"
                                  placeholder="Share your experience with this seller..."></textarea>
                        @error('review') 
                            <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Item Information Card -->
                    <div class="bg-[#eef1f8] rounded-lg p-4 mb-6 border border-[#c8d2e8]">
                        <div class="flex items-start gap-4">
                            @if($payment->listing->photos->first())
                                <img src="{{ $payment->listing->photos->first()->photo_path }}" 
                                     class="w-16 h-16 object-cover rounded-lg border border-[#c8d2e8]">
                            @else
                                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center border border-[#c8d2e8]">
                                    <i class="fas fa-image text-[#5a6480] text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-xs text-[#5a6480] mb-1">Item purchased</p>
                                <p class="font-semibold text-[#001f5e]">{{ $payment->listing->title }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs bg-white px-2 py-0.5 rounded-full text-[#5a6480] border border-[#c8d2e8]">{{ $payment->listing->category }}</span>
                                    <span class="text-xs bg-white px-2 py-0.5 rounded-full text-[#5a6480] border border-[#c8d2e8]">{{ $payment->listing->condition }}</span>
                                </div>
                                <p class="text-sm text-[#2e7d32] font-semibold mt-2">ETB {{ number_format($payment->amount, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-[#003087] hover:bg-[#001f5e] text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Submit Review
                        </button>
                        <a href="{{ route('listings.show', $payment->listing_id) }}" class="flex-1 bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] py-3 rounded-lg font-semibold text-center transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer Note -->
        <p class="text-center text-xs text-[#5a6480] mt-6">
            <i class="fas fa-lock text-[#003087] mr-1"></i> Your review helps build trust in the community
        </p>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('ratingValue');

    stars.forEach(star => {
        // Click event to set rating
        star.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            ratingInput.value = value;
            
            // Update stars to filled
            stars.forEach((s, index) => {
                if (index < value) {
                    s.className = 'fas fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#C8960C]';
                } else {
                    s.className = 'far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]';
                }
            });
        });
        
        // Hover effect for preview
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.getAttribute('data-value'));
            stars.forEach((s, index) => {
                if (index < value) {
                    s.className = 'fas fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#f59e0b]';
                } else {
                    s.className = 'far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]';
                }
            });
        });
    });
    
    // Reset stars on mouse leave
    const ratingContainer = document.getElementById('ratingStars');
    ratingContainer.addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.className = 'fas fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#C8960C]';
            } else {
                s.className = 'far fa-star cursor-pointer hover:scale-110 transition-all text-3xl text-[#5a6480] hover:text-[#C8960C]';
            }
        });
    });
</script>
@endsection