@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#003087]/10 rounded-full mb-4">
                <i class="fas fa-user-circle text-[#003087] text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-[#001f5e]">My Profile</h1>
            <p class="text-[#5a6480] mt-1">Manage your account settings and preferences</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] sticky top-24 overflow-hidden">
                    
                    <!-- Profile Picture Section -->
                    <div class="text-center p-6 border-b border-[#c8d2e8] bg-[#eef1f8]">
                        <!-- Profile Photo Display -->
                        <div class="relative inline-block">
                            @php
                                $profilePhoto = auth()->user()->profile_photo ? Storage::url(auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?background=003087&color=fff&rounded=true&size=120&name=' . urlencode(auth()->user()->name);
                            @endphp
                            <img id="profilePhotoPreview" 
                                 src="{{ $profilePhoto }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md">
                            
                            <!-- Edit Icon Overlay -->
                            <label for="profilePhotoInput" class="absolute bottom-0 right-0 w-8 h-8 bg-[#003087] rounded-full flex items-center justify-center cursor-pointer hover:bg-[#001f5e] transition shadow-md">
                                <i class="fas fa-camera text-white text-xs"></i>
                            </label>
                            <input type="file" id="profilePhotoInput" accept="image/*" class="hidden">
                        </div>
                        
                        <h3 class="text-xl font-bold text-[#001f5e] mt-3">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-[#5a6480]">{{ Auth::user()->email }}</p>
                        <div class="flex justify-center gap-2 mt-2 flex-wrap">
                            @if(Auth::user()->is_verified_seller)
                                <span class="inline-flex items-center gap-1 text-xs bg-[#2e7d32]/10 text-[#2e7d32] px-2 py-1 rounded-full">
                                    <i class="fas fa-check-circle"></i> Verified Seller
                                </span>
                            @endif
                            @if(Auth::user()->is_admin)
                                <span class="inline-flex items-center gap-1 text-xs bg-[#C8960C]/10 text-[#C8960C] px-2 py-1 rounded-full">
                                    <i class="fas fa-shield-alt"></i> Admin
                                </span>
                            @endif
                        </div>
                        
                        <!-- Remove Photo Link -->
                        @if(auth()->user()->profile_photo)
                            <button id="removePhotoBtn" class="mt-3 text-xs text-[#c0392b] hover:underline inline-flex items-center gap-1">
                                <i class="fas fa-trash-alt"></i> Remove Photo
                            </button>
                        @endif
                    </div>
                    
                    <!-- Stats Section -->
                    <div class="p-4 border-b border-[#c8d2e8]">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-[#5a6480]">Seller Rating</span>
                            <div class="flex items-center gap-1">
                                @php
                                    $rating = round(auth()->user()->averageRating());
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="fas fa-star text-[#C8960C] text-sm"></i>
                                    @else
                                        <i class="far fa-star text-[#5a6480] text-sm"></i>
                                    @endif
                                @endfor
                                <span class="text-xs text-[#5a6480] ml-1">({{ auth()->user()->ratingCount() }})</span>
                            </div>
                        </div>
                        <div class="w-full bg-[#eef1f8] rounded-full h-2">
                            <div class="bg-[#C8960C] h-2 rounded-full" style="width: {{ (auth()->user()->averageRating() / 5) * 100 }}%"></div>
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div class="p-4 space-y-3">
                        <div class="flex items-center gap-3 text-[#5a6480] text-sm">
                            <i class="fas fa-calendar-alt w-5 text-[#003087]"></i>
                            <span>Member since {{ Auth::user()->created_at->format('F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-[#5a6480] text-sm">
                            <i class="fas fa-graduation-cap w-5 text-[#003087]"></i>
                            <span>{{ Auth::user()->department ?? 'Department not set' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-[#5a6480] text-sm">
                            <i class="fas fa-university w-5 text-[#003087]"></i>
                            <span>{{ Auth::user()->university_domain ?? 'University not set' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-[#5a6480] text-sm">
                            <i class="fas fa-id-card w-5 text-[#003087]"></i>
                            <span class="font-mono">Student ID: {{ Auth::user()->student_id ?? 'Not provided' }}</span>
                        </div>
                    </div>
                    
                    <!-- ID Verification Link -->
                    <div class="p-4 border-t border-[#c8d2e8]">
                        <a href="{{ route('id-verification.show') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-[#003087] hover:bg-[#eef1f8] rounded-lg transition">
                            <i class="fas fa-id-card w-4"></i> 
                            ID Verification
                            @if(auth()->user()->id_verification_status == 'approved')
                                <span class="ml-auto text-xs bg-[#2e7d32]/10 text-[#2e7d32] px-2 py-0.5 rounded-full"><i class="fas fa-check-circle"></i> Verified</span>
                            @elseif(auth()->user()->id_verification_status == 'pending')
                                <span class="ml-auto text-xs bg-[#C8960C]/10 text-[#C8960C] px-2 py-0.5 rounded-full">Pending</span>
                            @else
                                <span class="ml-auto text-xs bg-[#c0392b]/10 text-[#c0392b] px-2 py-0.5 rounded-full">Not Verified</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Profile Information -->
                <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
                    <div class="border-b border-[#c8d2e8] px-6 py-4 bg-[#eef1f8]">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-edit text-[#003087] text-lg"></i>
                            <h3 class="text-lg font-semibold text-[#001f5e]">Profile Information</h3>
                        </div>
                        <p class="text-sm text-[#5a6480] mt-0.5">Update your account's profile information</p>
                    </div>
                    
                    <div class="p-6">
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                            @csrf
                            @method('patch')
                            
                            <div>
                                <label class="block text-sm font-medium text-[#001f5e] mb-2">
                                    <i class="fas fa-user text-[#C8960C] text-xs mr-1"></i> Full Name
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition">
                                @error('name') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#001f5e] mb-2">
                                    <i class="fas fa-envelope text-[#C8960C] text-xs mr-1"></i> Email Address
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20 text-[#1a1f36] transition">
                                @error('email') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                                
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 p-3 bg-[#C8960C]/10 border border-[#C8960C]/30 rounded-lg">
                                        <p class="text-sm text-[#C8960C]">
                                            Your email address is unverified.
                                            <button form="send-verification" class="underline hover:text-[#b07d0a]">Click here to re-send verification email.</button>
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                            
                            @if (session('status') === 'profile-updated')
                                <div class="mt-3 p-3 bg-[#2e7d32]/10 border border-[#2e7d32]/30 rounded-lg text-[#2e7d32] text-sm text-center">
                                    <i class="fas fa-check-circle mr-1"></i> Profile updated successfully!
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                
                <!-- Update Password -->
                <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
                    <div class="border-b border-[#c8d2e8] px-6 py-4 bg-[#eef1f8]">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-lock text-[#C8960C] text-lg"></i>
                            <h3 class="text-lg font-semibold text-[#001f5e]">Update Password</h3>
                        </div>
                        <p class="text-sm text-[#5a6480] mt-0.5">Ensure your account is using a secure password</p>
                    </div>
                    
                    <div class="p-6">
                        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('put')
                            
                            <div>
                                <label class="block text-sm font-medium text-[#001f5e] mb-2">Current Password</label>
                                <input type="password" name="current_password" class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                                @error('current_password', 'updatePassword') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#001f5e] mb-2">New Password</label>
                                <input type="password" name="password" class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                                @error('password', 'updatePassword') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[#001f5e] mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                            </div>
                            
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-key"></i> Update Password
                                </button>
                            </div>
                            
                            @if (session('status') === 'password-updated')
                                <div class="mt-3 p-3 bg-[#2e7d32]/10 border border-[#2e7d32]/30 rounded-lg text-[#2e7d32] text-sm text-center">
                                    <i class="fas fa-check-circle mr-1"></i> Password updated successfully!
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                
                <!-- Delete Account -->
                <div class="bg-[#c0392b]/5 rounded-xl shadow-sm border border-[#c0392b]/30 overflow-hidden">
                    <div class="border-b border-[#c0392b]/30 px-6 py-4 bg-[#c0392b]/5">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-trash-alt text-[#c0392b] text-lg"></i>
                            <h3 class="text-lg font-semibold text-[#c0392b]">Delete Account</h3>
                        </div>
                        <p class="text-sm text-[#5a6480] mt-0.5">Permanently delete your account and all data</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-[#c0392b]/5 rounded-lg p-4 mb-4 border border-[#c0392b]/20">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle text-[#c0392b] text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-[#c0392b] text-sm font-semibold mb-1">Warning: This action cannot be undone</p>
                                    <p class="text-[#5a6480] text-sm">
                                        Once your account is deleted, all of your listings, messages, favorites, and transaction history will be permanently removed.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-[#5a6480] text-sm mb-4">
                            Before deleting your account, please ensure you have downloaded any data you wish to retain.
                        </p>
                        
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                                class="inline-flex items-center gap-2 bg-[#c0392b]/10 hover:bg-[#c0392b]/20 text-[#c0392b] px-6 py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-exclamation-triangle"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Photo Upload Form (Hidden) -->
<form id="profilePhotoForm" method="POST" action="{{ route('profile.update-photo') }}" enctype="multipart/form-data" class="hidden">
    @csrf
    <input type="file" name="profile_photo" id="profilePhotoFile" accept="image/*">
</form>

<form id="removePhotoForm" method="POST" action="{{ route('profile.remove-photo') }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- Delete Account Modal -->
<div x-data="{ open: false }" x-show="open" x-on:open-modal.window="if ($event.detail === 'confirm-user-deletion') open = true" x-on:close.window="open = false" class="fixed inset-0 z-50 hidden items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" x-on:click="open = false"></div>
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 border border-[#c8d2e8] shadow-2xl z-10" x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-[#c0392b]/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-[#c0392b] text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-[#001f5e]">Delete Account</h3>
            </div>
            
            <p class="text-[#5a6480] mb-4">
                Are you sure you want to delete your account? This action cannot be undone.
            </p>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-[#001f5e] mb-2">Enter your password to confirm</label>
                <input type="password" name="password" placeholder="Your password" required
                       class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#c0392b] text-[#1a1f36] transition">
                @error('password', 'userDeletion') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 rounded-lg bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] font-semibold transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#c0392b]/10 border border-[#c0392b] text-[#c0392b] font-semibold hover:bg-[#c0392b]/20 transition">
                    Delete Forever
                </button>
            </div>
        </form>
    </div>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>

<script>
    // Profile Photo Upload
    const profilePhotoInput = document.getElementById('profilePhotoInput');
    const profilePhotoFile = document.getElementById('profilePhotoFile');
    const profilePhotoForm = document.getElementById('profilePhotoForm');
    const profilePhotoPreview = document.getElementById('profilePhotoPreview');
    
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('click', function() {
            profilePhotoFile.click();
        });
        
        profilePhotoFile.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    profilePhotoPreview.src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
                profilePhotoForm.submit();
            }
        });
    }
    
    // Remove Photo
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    const removePhotoForm = document.getElementById('removePhotoForm');
    
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            if (confirm('Remove your profile picture?')) {
                removePhotoForm.submit();
            }
        });
    }
    
    // Alpine.js modal
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            name: null,
            openModal(name) {
                this.name = name;
                this.open = true;
                document.body.style.overflow = 'hidden';
            },
            close() {
                this.open = false;
                this.name = null;
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
@endsection