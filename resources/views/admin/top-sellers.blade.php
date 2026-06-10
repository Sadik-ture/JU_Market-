@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">Top Rated Sellers</h1>
                <p class="text-[#5a6480] mt-1">Best performing sellers based on user ratings</p>
            </div>
            <div class="bg-gradient-to-r from-[#C8960C]/20 to-[#C8960C]/10 rounded-xl px-4 py-2 border border-[#C8960C]/30">
                <i class="fas fa-trophy text-[#C8960C] mr-2"></i>
                <span class="text-[#C8960C] font-semibold">Leaderboard</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#eef1f8]">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#5a6480]">Rank</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-[#5a6480]">Seller</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-[#5a6480]">Total Reviews</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-[#5a6480]">Average Rating</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-[#5a6480]">Verified</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-[#5a6480]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c8d2e8]">
                        @forelse($topSellers as $index => $seller)
                        <tr class="hover:bg-[#f4f6fb] transition">
                            <td class="px-6 py-4">
                                @if($index == 0)
                                    <div class="flex items-center gap-1">
                                        <span class="text-2xl">🥇</span>
                                        <span class="text-[#C8960C] font-bold">#1</span>
                                    </div>
                                @elseif($index == 1)
                                    <div class="flex items-center gap-1">
                                        <span class="text-2xl">🥈</span>
                                        <span class="text-[#5a6480] font-bold">#2</span>
                                    </div>
                                @elseif($index == 2)
                                    <div class="flex items-center gap-1">
                                        <span class="text-2xl">🥉</span>
                                        <span class="text-[#f59e0b] font-bold">#3</span>
                                    </div>
                                @else
                                    <span class="text-[#5a6480] font-bold">#{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[#003087] rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($seller->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-[#001f5e]">{{ $seller->name }}</p>
                                        <p class="text-xs text-[#5a6480]">{{ $seller->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-[#001f5e]">
                                {{ number_format($seller->ratings_count ?? 0) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($seller->avg_rating ?? 0))
                                                <i class="fas fa-star text-[#C8960C] text-sm"></i>
                                            @else
                                                <i class="far fa-star text-[#5a6480] text-sm"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-[#001f5e] ml-2">{{ number_format($seller->avg_rating ?? 0, 1) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($seller->is_verified_seller)
                                    <span class="bg-[#2e7d32]/10 text-[#2e7d32] px-2 py-1 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="bg-[#C8960C]/10 text-[#C8960C] px-2 py-1 rounded-full text-xs">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.users') }}?search={{ $seller->id }}" class="bg-[#003087]/10 text-[#003087] px-3 py-1 rounded-lg text-sm hover:bg-[#003087]/20 transition">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-[#5a6480]">
                                    <i class="fas fa-star text-4xl mb-3 block"></i>
                                    <p>No ratings yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection