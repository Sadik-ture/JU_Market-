@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">Ratings Management</h1>
                <p class="text-[#5a6480] mt-1">Monitor and manage user reviews</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm px-4 py-2 border border-[#c8d2e8]">
                <i class="fas fa-star text-[#C8960C] mr-2"></i>
                <span class="text-sm text-[#5a6480]">All Reviews</span>
            </div>
        </div>
        
        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#5a6480] text-sm mb-1">Total Ratings</p>
                        <p class="text-3xl font-bold text-[#001f5e]">{{ number_format($stats['total']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#003087]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-[#003087] text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5a6480]">All time reviews</span>
                        <span class="text-[#003087] font-semibold">100%</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-1.5 mt-2">
                        <div class="bg-[#003087] h-1.5 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#5a6480] text-sm mb-1">Approved</p>
                        <p class="text-3xl font-bold text-[#2e7d32]">{{ number_format($stats['approved']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#2e7d32]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-[#2e7d32] text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5a6480]">Visible to users</span>
                        <span class="text-[#2e7d32] font-semibold">{{ $stats['total'] > 0 ? round(($stats['approved'] / $stats['total']) * 100) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-1.5 mt-2">
                        <div class="bg-[#2e7d32] h-1.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['approved'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#5a6480] text-sm mb-1">Pending</p>
                        <p class="text-3xl font-bold text-[#C8960C]">{{ number_format($stats['pending']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#C8960C]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-[#C8960C] text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5a6480]">Awaiting review</span>
                        <span class="text-[#C8960C] font-semibold">{{ $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-1.5 mt-2">
                        <div class="bg-[#C8960C] h-1.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['pending'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-5 transition hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[#5a6480] text-sm mb-1">Average Rating</p>
                        <p class="text-3xl font-bold text-[#003087]">{{ number_format($stats['average_rating'], 1) }} ★</p>
                    </div>
                    <div class="w-12 h-12 bg-[#C8960C]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-[#C8960C] text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-[#c8d2e8]">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5a6480]">Overall score</span>
                        <span class="text-[#003087] font-semibold">{{ number_format($stats['average_rating'] / 5 * 100, 0) }}%</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-1.5 mt-2">
                        <div class="bg-[#C8960C] h-1.5 rounded-full" style="width: {{ $stats['average_rating'] / 5 * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rating Distribution Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] p-6 mb-8">
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-chart-bar text-[#C8960C] text-lg"></i>
                <h3 class="text-lg font-semibold text-[#001f5e]">Rating Distribution</h3>
                <span class="text-xs text-[#5a6480] ml-auto">Based on {{ number_format($stats['total']) }} reviews</span>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-[#5a6480] flex items-center gap-1.5"><i class="fas fa-star text-[#C8960C] text-xs"></i> 5 Stars - Excellent</span>
                        <span class="text-[#001f5e] font-semibold">{{ number_format($stats['five_stars']) }}</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-2.5">
                        <div class="bg-[#2e7d32] h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['five_stars'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-[#5a6480] flex items-center gap-1.5"><i class="fas fa-star text-[#C8960C] text-xs"></i> 4 Stars - Good</span>
                        <span class="text-[#001f5e] font-semibold">{{ number_format($stats['four_stars']) }}</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-2.5">
                        <div class="bg-[#003087] h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['four_stars'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-[#5a6480] flex items-center gap-1.5"><i class="fas fa-star text-[#C8960C] text-xs"></i> 3 Stars - Average</span>
                        <span class="text-[#001f5e] font-semibold">{{ number_format($stats['three_stars']) }}</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-2.5">
                        <div class="bg-[#C8960C] h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['three_stars'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-[#5a6480] flex items-center gap-1.5"><i class="fas fa-star text-[#C8960C] text-xs"></i> 2 Stars - Below Average</span>
                        <span class="text-[#001f5e] font-semibold">{{ number_format($stats['two_stars']) }}</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-2.5">
                        <div class="bg-[#f59e0b] h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['two_stars'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-[#5a6480] flex items-center gap-1.5"><i class="fas fa-star text-[#C8960C] text-xs"></i> 1 Star - Poor</span>
                        <span class="text-[#001f5e] font-semibold">{{ number_format($stats['one_star']) }}</span>
                    </div>
                    <div class="w-full bg-[#eef1f8] rounded-full h-2.5">
                        <div class="bg-[#c0392b] h-2.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($stats['one_star'] / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden mb-6">
            <div class="p-5 border-b border-[#c8d2e8] bg-[#eef1f8]">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="relative md:col-span-2">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#5a6480]"></i>
                        <input type="text" name="search" placeholder="Search by user or review..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition">
                    </div>
                    
                    <select name="status" class="px-4 py-2.5 bg-white border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    </select>
                    
                    <select name="rating" class="px-4 py-2.5 bg-white border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★ (5)</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>★★★★☆ (4)</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>★★★☆☆ (3)</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>★★☆☆☆ (2)</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆ (1)</option>
                    </select>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-[#003087] hover:bg-[#001f5e] text-white px-4 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i> Apply
                        </button>
                        <a href="{{ route('admin.ratings') }}" class="flex-1 bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-4 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Bulk Actions -->
            <div class="p-4 border-b border-[#c8d2e8] bg-white flex flex-wrap gap-3">
                <button onclick="bulkApprove()" class="bg-[#2e7d32]/10 hover:bg-[#2e7d32]/20 text-[#2e7d32] px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> Approve Selected
                </button>
                <button onclick="bulkDelete()" class="bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-trash-alt"></i> Delete Selected
                </button>
            </div>
        </div>
        
        <!-- Ratings Table -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            <div class="overflow-x-auto">
                <form id="bulkForm" method="POST">
                    @csrf
                    <table class="w-full">
                        <thead class="bg-[#eef1f8] border-b border-[#c8d2e8]">
                            <tr>
                                <th class="px-4 py-3 w-10"><input type="checkbox" id="selectAll" class="rounded border-[#c8d2e8] w-4 h-4"></th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Reviewer</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Seller</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Item</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Rating</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Review</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Date</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#c8d2e8]">
                            @forelse($ratings as $rating)
                            <tr class="hover:bg-[#f4f6fb] transition">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" name="ids[]" value="{{ $rating->id }}" class="rating-checkbox rounded border-[#c8d2e8] w-4 h-4">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-[#003087]/10 rounded-full flex items-center justify-center text-[#003087] text-xs font-bold">
                                            {{ substr($rating->fromUser->name, 0, 1) }}
                                        </div>
                                        <span class="text-[#1a1f36] text-sm font-medium">{{ $rating->fromUser->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-[#2e7d32]/10 rounded-full flex items-center justify-center text-[#2e7d32] text-xs font-bold">
                                            {{ substr($rating->toUser->name, 0, 1) }}
                                        </div>
                                        <span class="text-[#1a1f36] text-sm font-medium">{{ $rating->toUser->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('listings.show', $rating->listing) }}" class="text-[#003087] hover:text-[#C8960C] transition text-sm">
                                        {{ Str::limit($rating->listing->title, 30) }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rating->rating)
                                                <i class="fas fa-star text-[#C8960C] text-sm"></i>
                                            @else
                                                <i class="far fa-star text-[#5a6480] text-sm"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs text-[#5a6480] block mt-1">{{ $rating->rating }}/5</span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-[#5a6480] text-sm max-w-xs line-clamp-2">{{ Str::limit($rating->review ?? 'No review', 80) }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($rating->is_approved)
                                        <span class="inline-flex items-center gap-1 text-xs bg-[#2e7d32]/10 text-[#2e7d32] px-2.5 py-1 rounded-full">
                                            <i class="fas fa-check-circle text-xs"></i> Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs bg-[#C8960C]/10 text-[#C8960C] px-2.5 py-1 rounded-full">
                                            <i class="fas fa-clock text-xs"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-[#5a6480] text-sm">
                                    {{ $rating->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        @if(!$rating->is_approved)
                                        <form method="POST" action="{{ route('admin.ratings.approve', $rating) }}" class="inline" onsubmit="return confirm('Approve this rating?')">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 bg-[#2e7d32]/10 hover:bg-[#2e7d32]/20 text-[#2e7d32] rounded-lg transition flex items-center justify-center" title="Approve Rating">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <a href="{{ route('admin.ratings.show', $rating) }}" class="w-8 h-8 bg-[#003087]/10 hover:bg-[#003087]/20 text-[#003087] rounded-lg inline-flex items-center justify-center transition" title="View Details">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.ratings.destroy', $rating) }}" class="inline" onsubmit="return confirm('⚠️ Delete this rating permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] rounded-lg transition flex items-center justify-center" title="Delete Rating">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-star text-5xl text-[#5a6480] mb-3 opacity-40"></i>
                                        <p class="text-[#5a6480] text-lg font-medium">No ratings found</p>
                                        <p class="text-[#5a6480] text-sm mt-1">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
            
            <!-- Pagination -->
            @if($ratings->count() > 0)
            <div class="p-5 border-t border-[#c8d2e8] bg-white flex justify-center">
                {{ $ratings->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.rating-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }
    
    // Bulk approve function
    function bulkApprove() {
        const selected = document.querySelectorAll('.rating-checkbox:checked');
        if (selected.length === 0) {
            alert('📋 Please select at least one rating to approve');
            return;
        }
        if (confirm(`✅ Approve ${selected.length} rating(s)?\n\nThis will make them visible to all users.`)) {
            document.getElementById('bulkForm').action = "{{ route('admin.ratings.bulk-approve') }}";
            document.getElementById('bulkForm').submit();
        }
    }
    
    // Bulk delete function
    function bulkDelete() {
        const selected = document.querySelectorAll('.rating-checkbox:checked');
        if (selected.length === 0) {
            alert('📋 Please select at least one rating to delete');
            return;
        }
        if (confirm(`⚠️ DELETE ${selected.length} rating(s)\n\nThis action CANNOT be undone!\n\nAll selected reviews will be permanently removed.`)) {
            document.getElementById('bulkForm').action = "{{ route('admin.ratings.bulk-delete') }}";
            document.getElementById('bulkForm').submit();
        }
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pagination .page-item .page-link {
        padding: 8px 14px;
        border-radius: 10px;
        background: white;
        border: 1px solid #c8d2e8;
        color: #003087;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination .page-item.active .page-link {
        background: #003087;
        border-color: #003087;
        color: white;
    }
    .pagination .page-item .page-link:hover {
        background: #eef1f8;
        border-color: #003087;
    }
</style>
@endsection