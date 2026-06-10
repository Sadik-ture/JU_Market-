@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">User Management</h1>
                <p class="text-[#5a6480] mt-1">Manage all registered students and their accounts</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm px-4 py-2 border border-[#c8d2e8]">
                <span class="text-sm text-[#5a6480]">Total Users:</span>
                <span class="text-xl font-bold text-[#003087] ml-2">{{ number_format($users->total()) }}</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Search & Filters -->
            <div class="p-5 border-b border-[#c8d2e8]">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative md:col-span-2">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#5a6480] text-sm"></i>
                        <input type="text" name="search" placeholder="Search by name, email, or student ID..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition">
                    </div>
                    
                    <select name="university" class="px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                        <option value="">All Universities</option>
                        @foreach($universities as $uni)
                            <option value="{{ $uni }}" {{ request('university') == $uni ? 'selected' : '' }}>{{ $uni }}</option>
                        @endforeach
                    </select>
                    
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.users') }}" class="bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-5 border-b border-[#c8d2e8]">
                <div class="text-center p-2 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#003087]">{{ number_format($users->total()) }}</p>
                    <p class="text-xs text-[#5a6480]">Total Users</p>
                </div>
                <div class="text-center p-2 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#2e7d32]">{{ number_format($users->where('is_verified_seller', true)->count()) }}</p>
                    <p class="text-xs text-[#5a6480]">Verified Sellers</p>
                </div>
                <div class="text-center p-2 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#C8960C]">{{ number_format($users->where('is_admin', true)->count()) }}</p>
                    <p class="text-xs text-[#5a6480]">Admins</p>
                </div>
                <div class="text-center p-2 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#c0392b]">{{ number_format($users->where('is_suspended', true)->count()) }}</p>
                    <p class="text-xs text-[#5a6480]">Suspended</p>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="m-4 p-3 bg-[#2e7d32]/10 border border-[#2e7d32]/30 rounded-lg text-[#2e7d32] text-sm flex items-center gap-2 animate-pulse">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="m-4 p-3 bg-[#c0392b]/10 border border-[#c0392b]/30 rounded-lg text-[#c0392b] text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#eef1f8]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">User</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Student ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Email</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">University</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Verified</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Role</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c8d2e8]">
                        @foreach($users as $user)
                        <tr class="hover:bg-[#f4f6fb] transition group">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-[#003087] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#001f5e]">{{ $user->name }}</p>
                                        <p class="text-xs text-[#5a6480]">Joined {{ $user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm font-mono">{{ $user->student_id ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 text-xs bg-[#eef1f8] px-2 py-1 rounded-full">
                                    <i class="fas fa-university text-[#5a6480] text-xs"></i>
                                    {{ $user->university_domain ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($user->is_verified_seller)
                                    <span class="inline-flex items-center gap-1 text-[#2e7d32] text-sm"><i class="fas fa-check-circle"></i> Yes</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[#C8960C] text-sm"><i class="fas fa-clock"></i> No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($user->is_admin)
                                    <span class="bg-[#C8960C]/10 text-[#C8960C] px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-crown mr-1"></i> Admin
                                    </span>
                                @else
                                    <span class="bg-[#eef1f8] text-[#5a6480] px-2 py-1 rounded-full text-xs">
                                        <i class="fas fa-user mr-1"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($user->is_suspended)
                                    <span class="bg-[#c0392b]/10 text-[#c0392b] px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-ban mr-1"></i> Suspended
                                    </span>
                                @else
                                    <span class="bg-[#2e7d32]/10 text-[#2e7d32] px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-circle mr-1 text-[6px]"></i> Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-1.5">
                                    <!-- Verify Seller Button -->
                                    @if(!$user->is_verified_seller)
                                    <form method="POST" action="{{ route('admin.users.verify-seller', $user) }}" class="inline" onsubmit="return confirm('Verify {{ $user->name }} as a seller?')">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-[#2e7d32]/10 hover:bg-[#2e7d32]/20 text-[#2e7d32] rounded-lg transition flex items-center justify-center tooltip" title="Verify Seller">
                                            <i class="fas fa-check text-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <!-- Suspend/Activate Button -->
                                    <form method="POST" action="{{ route('admin.users.toggle-suspend', $user) }}" class="inline" onsubmit="return confirm('{{ $user->is_suspended ? 'Activate' : 'Suspend' }} {{ $user->name }}?')">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-[#C8960C]/10 hover:bg-[#C8960C]/20 text-[#C8960C] rounded-lg transition flex items-center justify-center tooltip" title="{{ $user->is_suspended ? 'Activate User' : 'Suspend User' }}">
                                            <i class="fas {{ $user->is_suspended ? 'fa-play' : 'fa-pause' }} text-sm"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Make Admin Button -->
                                    @if(!$user->is_admin && $user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.make-admin', $user) }}" class="inline" onsubmit="return confirm('Make {{ $user->name }} an administrator?')">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-[#003087]/10 hover:bg-[#003087]/20 text-[#003087] rounded-lg transition flex items-center justify-center tooltip" title="Make Admin">
                                            <i class="fas fa-crown text-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <!-- Delete User Button -->
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirmDialog('{{ $user->name }}')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] rounded-lg transition flex items-center justify-center tooltip" title="Delete User">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-[#c8d2e8]">
                {{ $users->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>

<script>
function confirmDialog(userName) {
    return confirm(`⚠️ DELETE USER\n\nAre you sure you want to delete "${userName}" permanently?\n\nAll their listings, messages, and data will be removed.\n\nThis action cannot be undone!`);
}

// Auto-hide success messages after 5 seconds
setTimeout(function() {
    let successMessages = document.querySelectorAll('.bg-\\[\\#2e7d32\\]\\/10');
    successMessages.forEach(function(msg) {
        msg.style.transition = 'opacity 0.5s';
        msg.style.opacity = '0';
        setTimeout(function() {
            msg.remove();
        }, 500);
    });
}, 5000);
</script>

<style>
.tooltip {
    position: relative;
    cursor: pointer;
}

.tooltip:hover::after {
    content: attr(title);
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #1a1f36;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    white-space: nowrap;
    z-index: 50;
}
</style>
@endsection