@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">Listing Management</h1>
                <p class="text-[#5a6480] mt-1">Manage all marketplace listings</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm px-4 py-2 border border-[#c8d2e8]">
                <span class="text-sm text-[#5a6480]">Total:</span>
                <span class="text-xl font-bold text-[#003087] ml-2">{{ number_format($listings->total()) }}</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Filters -->
            <div class="p-5 border-b border-[#c8d2e8]">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#5a6480] text-sm"></i>
                        <input type="text" name="search" placeholder="Search listings..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition">
                    </div>
                    
                    <select name="status" class="px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    
                    <select name="category" class="px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-[#003087] hover:bg-[#001f5e] text-white px-4 py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.listings') }}" class="flex-1 bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-4 py-2.5 rounded-lg font-semibold transition text-center">
                            <i class="fas fa-times mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="m-4 p-3 bg-[#2e7d32]/10 border border-[#2e7d32]/30 rounded-lg text-[#2e7d32] text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Listings Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#eef1f8]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Image</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Title</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Seller</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Price</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Category</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Views</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c8d2e8]">
                        @foreach($listings as $listing)
                        <tr class="hover:bg-[#f4f6fb] transition">
                            <td class="px-4 py-3">
                                @if($listing->photos->first())
                                    <img src="{{ $listing->photos->first()->photo_path }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-[#eef1f8] rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-[#5a6480]"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-[#001f5e]">{{ Str::limit($listing->title, 30) }}</td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $listing->user->name }}</td>
                            <td class="px-4 py-3 font-semibold text-[#2e7d32]">ETB {{ number_format($listing->price, 2) }}</td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $listing->category }}</td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ number_format($listing->views_count) }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.listings.status', $listing) }}" class="inline">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" 
                                        class="text-xs rounded-lg px-2 py-1.5 font-semibold cursor-pointer border
                                        @if($listing->status == 'Active') bg-[#2e7d32]/10 text-[#2e7d32] border-[#2e7d32]/30
                                        @elseif($listing->status == 'Sold') bg-[#5a6480]/10 text-[#5a6480] border-[#5a6480]/30
                                        @else bg-[#C8960C]/10 text-[#C8960C] border-[#C8960C]/30
                                        @endif">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ $listing->status == $status ? 'selected' : '' }} class="bg-white text-[#1a1f36]">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ route('admin.listings.destroy', $listing) }}" 
                                      onsubmit="return confirm('⚠️ Delete this listing permanently?\nThis action cannot be undone.')"
                                      class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1 mx-auto">
                                        <i class="fas fa-trash-alt text-xs"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-[#c8d2e8]">
                {{ $listings->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection