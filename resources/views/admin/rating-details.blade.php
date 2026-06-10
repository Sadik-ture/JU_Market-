@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.ratings') }}" class="inline-flex items-center gap-2 text-[#003087] hover:text-[#C8960C] transition">
                <i class="fas fa-arrow-left"></i> Back to Ratings
            </a>
        </div>
        
        <!-- Rating Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Header -->
            <div class="border-b border-[#c8d2e8] px-6 py-4 bg-[#eef1f8]">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-[#001f5e]">Rating Details</h2>
                        <p class="text-sm text-[#5a6480] mt-1">Review information and transaction details</p>
                    </div>
                    <div class="flex gap-2">
                        @if(!$rating->is_approved)
                        <form method="POST" action="{{ route('admin.ratings.approve', $rating) }}" onsubmit="return confirm('Approve this rating?')">
                            @csrf
                            <button type="submit" class="bg-[#2e7d32]/10 hover:bg-[#2e7d32]/20 text-[#2e7d32] px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <i class="fas fa-check-circle"></i> Approve Rating
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.ratings.destroy', $rating) }}" onsubmit="return confirm('⚠️ Delete this rating permanently?\nThis action cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <i class="fas fa-trash-alt"></i> Delete Rating
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                
                <!-- Rating Display -->
                <div class="text-center mb-6 p-4 bg-[#eef1f8] rounded-xl">
                    <div class="inline-flex items-center gap-1 text-3xl">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating->rating)
                                <i class="fas fa-star text-[#C8960C]"></i>
                            @else
                                <i class="far fa-star text-[#5a6480]"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-sm text-[#5a6480] mt-2">{{ $rating->rating }} out of 5 stars</p>
                    <div class="mt-2">
                        @if($rating->is_approved)
                            <span class="inline-flex items-center gap-1 text-xs bg-[#2e7d32]/10 text-[#2e7d32] px-2 py-1 rounded-full">
                                <i class="fas fa-check-circle"></i> Approved
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs bg-[#C8960C]/10 text-[#C8960C] px-2 py-1 rounded-full">
                                <i class="fas fa-clock"></i> Pending Approval
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Review Text -->
                <div class="bg-[#f4f6fb] rounded-xl p-5 mb-6 border border-[#c8d2e8]">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-quote-left text-[#C8960C] text-xl mt-1"></i>
                        <p class="text-[#1a1f36] italic leading-relaxed">"{{ $rating->review ?? 'No review text provided.' }}"</p>
                    </div>
                </div>
                
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    
                    <!-- From User (Reviewer) -->
                    <div class="bg-[#f4f6fb] rounded-xl p-4 border border-[#c8d2e8]">
                        <h3 class="text-sm font-semibold text-[#5a6480] mb-3 flex items-center gap-2">
                            <i class="fas fa-user-circle text-[#003087]"></i> Reviewer
                        </h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#003087] rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($rating->fromUser->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-[#001f5e]">{{ $rating->fromUser->name }}</p>
                                <p class="text-xs text-[#5a6480]">{{ $rating->fromUser->email }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#5a6480]">Student ID:</span>
                                <span class="text-[#1a1f36] font-mono">{{ $rating->fromUser->student_id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-[#5a6480]">Department:</span>
                                <span class="text-[#1a1f36]">{{ $rating->fromUser->department ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.users') }}?search={{ $rating->fromUser->id }}" class="mt-3 inline-flex items-center gap-1 text-[#003087] text-sm hover:text-[#C8960C] transition">
                            View Profile <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                    
                    <!-- To User (Seller) -->
                    <div class="bg-[#f4f6fb] rounded-xl p-4 border border-[#c8d2e8]">
                        <h3 class="text-sm font-semibold text-[#5a6480] mb-3 flex items-center gap-2">
                            <i class="fas fa-store text-[#C8960C]"></i> Seller
                        </h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#2e7d32] rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($rating->toUser->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-[#001f5e]">{{ $rating->toUser->name }}</p>
                                <p class="text-xs text-[#5a6480]">{{ $rating->toUser->email }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#5a6480]">Avg Rating:</span>
                                <span class="text-[#C8960C] font-semibold">{{ number_format($rating->toUser->rating_avg ?? 0, 1) }} ★</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-[#5a6480]">Verified Seller:</span>
                                <span class="{{ $rating->toUser->is_verified_seller ? 'text-[#2e7d32]' : 'text-[#C8960C]' }}">
                                    {{ $rating->toUser->is_verified_seller ? '✓ Yes' : '⏳ Pending' }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.users') }}?search={{ $rating->toUser->id }}" class="mt-3 inline-flex items-center gap-1 text-[#003087] text-sm hover:text-[#C8960C] transition">
                            View Profile <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Item Details -->
                <div class="bg-[#f4f6fb] rounded-xl p-4 mb-6 border border-[#c8d2e8]">
                    <h3 class="text-sm font-semibold text-[#5a6480] mb-3 flex items-center gap-2">
                        <i class="fas fa-box-open text-[#003087]"></i> Item Information
                    </h3>
                    <div class="flex items-center gap-4">
                        @if($rating->listing->photos->first())
                            <img src="{{ $rating->listing->photos->first()->photo_path }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center border border-[#c8d2e8]">
                                <i class="fas fa-image text-[#5a6480] text-2xl"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <a href="{{ route('listings.show', $rating->listing) }}" class="font-semibold text-[#001f5e] hover:text-[#C8960C] transition">
                                {{ $rating->listing->title }}
                            </a>
                            <div class="flex flex-wrap gap-2 mt-1">
                                <span class="text-xs bg-white px-2 py-0.5 rounded-full text-[#5a6480] border border-[#c8d2e8]">{{ $rating->listing->category }}</span>
                                <span class="text-xs bg-white px-2 py-0.5 rounded-full text-[#5a6480] border border-[#c8d2e8]">{{ $rating->listing->condition }}</span>
                            </div>
                            <p class="text-sm text-[#2e7d32] font-semibold mt-1">ETB {{ number_format($rating->listing->price, 2) }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction Details -->
                <div class="bg-[#f4f6fb] rounded-xl p-4 border border-[#c8d2e8]">
                    <h3 class="text-sm font-semibold text-[#5a6480] mb-3 flex items-center gap-2">
                        <i class="fas fa-receipt text-[#C8960C]"></i> Transaction Information
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-[#5a6480] block text-xs">Payment ID</span>
                            <p class="text-[#1a1f36] font-mono text-xs">{{ $rating->payment_id }}</p>
                        </div>
                        <div>
                            <span class="text-[#5a6480] block text-xs">Transaction ID</span>
                            <p class="text-[#1a1f36] font-mono text-xs">{{ Str::limit($rating->payment->transaction_id ?? 'N/A', 16) }}</p>
                        </div>
                        <div>
                            <span class="text-[#5a6480] block text-xs">Amount</span>
                            <p class="text-[#2e7d32] font-semibold">ETB {{ number_format($rating->payment->amount ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <span class="text-[#5a6480] block text-xs">Payment Status</span>
                            <p class="text-[#2e7d32] font-semibold">{{ ucfirst($rating->payment->status ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <span class="text-[#5a6480] block text-xs">Review Date</span>
                            <p class="text-[#1a1f36]">{{ $rating->created_at->format('F j, Y g:i A') }}</p>
                        </div>
                        <div>
                            <span class="text-[#5a6480] block text-xs">Review Status</span>
                            @if($rating->is_approved)
                                <span class="inline-flex items-center gap-1 text-[#2e7d32] text-xs"><i class="fas fa-check-circle"></i> Approved</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[#C8960C] text-xs"><i class="fas fa-clock"></i> Pending</span>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection