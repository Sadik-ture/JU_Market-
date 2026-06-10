@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">Student ID Verification</h1>
                <p class="text-[#5a6480] mt-1">Review and verify student identity documents</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm px-4 py-2 border border-[#c8d2e8]">
                <span class="text-sm text-[#5a6480]">Pending:</span>
                <span class="text-xl font-bold text-[#C8960C] ml-2">{{ $users->total() }}</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Stats Summary -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-5 border-b border-[#c8d2e8]">
                <div class="text-center p-3 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#C8960C]">{{ \App\Models\User::where('id_verification_status', 'pending')->count() }}</p>
                    <p class="text-xs text-[#5a6480]">Pending</p>
                </div>
                <div class="text-center p-3 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#2e7d32]">{{ \App\Models\User::where('id_verification_status', 'approved')->count() }}</p>
                    <p class="text-xs text-[#5a6480]">Approved</p>
                </div>
                <div class="text-center p-3 bg-[#eef1f8] rounded-lg">
                    <p class="text-2xl font-bold text-[#c0392b]">{{ \App\Models\User::where('id_verification_status', 'rejected')->count() }}</p>
                    <p class="text-xs text-[#5a6480]">Rejected</p>
                </div>
            </div>
            
            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#eef1f8]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Student</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Student ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Email</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">ID Card</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Submitted</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-[#5a6480]">Actions</th>
                        <tr>
                    </thead>
                    <tbody class="divide-y divide-[#c8d2e8]">
                        @forelse($users as $user)
                        <tr class="hover:bg-[#f4f6fb] transition">
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
                                <button onclick="showIDModal('{{ Storage::url($user->id_photo_path) }}', '{{ $user->name }}')" 
                                        class="bg-[#003087]/10 text-[#003087] px-3 py-1 rounded-lg text-sm hover:bg-[#003087]/20 transition flex items-center gap-1">
                                    <i class="fas fa-id-card"></i> View ID
                                </button>
                            </td>
                            <td class="px-4 py-3 text-center text-[#5a6480] text-sm">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <form method="POST" action="{{ route('admin.users.approve-id', $user) }}" class="inline" onsubmit="return confirm('Approve {{ $user->name }}\'s ID verification?')">
                                        @csrf
                                        <button type="submit" class="bg-[#2e7d32]/10 hover:bg-[#2e7d32]/20 text-[#2e7d32] px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    
                                    <button onclick="showRejectModal({{ $user->id }}, '{{ $user->name }}')" 
                                            class="bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-3 py-1.5 rounded-lg text-sm transition flex items-center gap-1">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-[#5a6480]">
                                <i class="fas fa-id-card text-4xl mb-3 block"></i>
                                <p>No pending ID verifications.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-5 border-t border-[#c8d2e8]">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ID Image Modal -->
<div id="idModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center" onclick="closeIDModal()">
    <div class="bg-white rounded-2xl max-w-lg w-full mx-4 border border-[#c8d2e8] shadow-xl" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-4 border-b border-[#c8d2e8]">
            <h3 class="text-lg font-bold text-[#001f5e]" id="modalTitle">Student ID Card</h3>
            <button onclick="closeIDModal()" class="text-[#5a6480] hover:text-[#003087] text-2xl">&times;</button>
        </div>
        <div class="p-4">
            <img id="idImage" src="" alt="Student ID" class="w-full rounded-lg">
        </div>
        <div class="p-4 border-t border-[#c8d2e8] text-right">
            <button onclick="closeIDModal()" class="bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-4 py-2 rounded-lg transition">Close</button>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center" onclick="closeRejectModal()">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 border border-[#c8d2e8] shadow-xl" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center p-4 border-b border-[#c8d2e8]">
            <h3 class="text-lg font-bold text-[#001f5e]">Reject ID Verification</h3>
            <button onclick="closeRejectModal()" class="text-[#5a6480] hover:text-[#c0392b] text-2xl">&times;</button>
        </div>
        <form method="POST" id="rejectForm" action="">
            @csrf
            <div class="p-4">
                <label class="block text-sm font-medium text-[#001f5e] mb-2">Reason for Rejection</label>
                <textarea name="reason" rows="3" required 
                          class="w-full px-4 py-2 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#c0392b] text-[#1a1f36]"
                          placeholder="Please explain why the ID is being rejected..."></textarea>
                <p class="text-xs text-[#5a6480] mt-2">This reason will be shown to the student.</p>
            </div>
            <div class="p-4 border-t border-[#c8d2e8] text-right flex gap-2 justify-end">
                <button type="button" onclick="closeRejectModal()" class="bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-4 py-2 rounded-lg transition">Cancel</button>
                <button type="submit" class="bg-[#c0392b] hover:bg-[#a93226] text-white px-4 py-2 rounded-lg transition">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showIDModal(imageUrl, userName) {
        document.getElementById('idImage').src = imageUrl;
        document.getElementById('modalTitle').innerText = userName + '\'s ID Card';
        document.getElementById('idModal').classList.remove('hidden');
        document.getElementById('idModal').style.display = 'flex';
    }
    
    function closeIDModal() {
        document.getElementById('idModal').classList.add('hidden');
        document.getElementById('idModal').style.display = 'none';
    }
    
    function showRejectModal(userId, userName) {
        const form = document.getElementById('rejectForm');
        form.action = '/admin/users/' + userId + '/reject-id';
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').style.display = 'flex';
        document.getElementById('rejectModal').scrollTop = 0;
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').style.display = 'none';
    }
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeIDModal();
            closeRejectModal();
        }
    });
</script>
@endsection