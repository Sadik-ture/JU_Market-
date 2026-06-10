@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Header -->
            <div class="bg-[#eef1f8] border-b border-[#c8d2e8] px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#003087]/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-id-card text-[#003087] text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-[#001f5e]">Student ID Verification</h2>
                        <p class="text-sm text-[#5a6480] mt-0.5">Verify your identity to get the "Verified Student" badge</p>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                
                <!-- Current Status Card -->
                <div class="bg-[#f4f6fb] rounded-lg p-4 mb-6 border border-[#c8d2e8]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-[#5a6480] uppercase tracking-wider">Current Status</p>
                            <div class="mt-1">
                                @if(auth()->user()->id_verification_status == 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#2e7d32]/10 text-[#2e7d32] rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle"></i> VERIFIED
                                    </span>
                                @elseif(auth()->user()->id_verification_status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#C8960C]/10 text-[#C8960C] rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock"></i> PENDING REVIEW
                                    </span>
                                @elseif(auth()->user()->id_verification_status == 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#c0392b]/10 text-[#c0392b] rounded-full text-sm font-semibold">
                                        <i class="fas fa-times-circle"></i> REJECTED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#5a6480]/10 text-[#5a6480] rounded-full text-sm font-semibold">
                                        <i class="fas fa-id-card"></i> NOT SUBMITTED
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(auth()->user()->id_verification_status == 'approved')
                            <div class="w-12 h-12 bg-[#2e7d32]/10 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-[#2e7d32] text-2xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- CASE 1: APPROVED -->
                @if(auth()->user()->id_verification_status == 'approved')
                    <div class="text-center py-8">
                        <div class="w-24 h-24 bg-[#2e7d32]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-id-card text-[#2e7d32] text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#001f5e] mb-2">Verification Complete!</h3>
                        <p class="text-[#5a6480] mb-6">Your student ID has been verified. You now have the "Verified Student" badge on your profile.</p>
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition">
                                <i class="fas fa-arrow-right"></i> Go to Dashboard
                            </a>
                        </div>
                    </div>

                <!-- CASE 2: PENDING -->
                @elseif(auth()->user()->id_verification_status == 'pending')
                    <div class="text-center py-8">
                        <div class="w-24 h-24 bg-[#C8960C]/10 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="fas fa-hourglass-half text-[#C8960C] text-4xl animate-pulse"></i>
                        </div>
                        <h3 class="text-xl font-bold text-[#001f5e] mb-2">Verification Pending</h3>
                        <p class="text-[#5a6480] mb-4">Your student ID is being reviewed by our admin team.</p>
                        <div class="bg-[#eef1f8] rounded-lg p-4 inline-block">
                            <p class="text-sm text-[#5a6480]">📋 This usually takes less than 24 hours</p>
                        </div>
                        @if(auth()->user()->id_photo_path)
                            <div class="mt-6">
                                <p class="text-sm text-[#5a6480] mb-2">Your submitted ID:</p>
                                <img src="{{ Storage::url(auth()->user()->id_photo_path) }}" class="w-48 mx-auto rounded-lg border border-[#c8d2e8] shadow-sm">
                            </div>
                        @endif
                    </div>

                <!-- CASE 3: REJECTED -->
                @elseif(auth()->user()->id_verification_status == 'rejected')
                    <div class="bg-[#c0392b]/10 border border-[#c0392b]/30 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-[#c0392b] mt-0.5"></i>
                            <div>
                                <p class="text-[#c0392b] font-semibold text-sm mb-1">Your ID was rejected</p>
                                <p class="text-[#5a6480] text-sm">Reason: {{ auth()->user()->id_verification_notes ?? 'Please upload a clear image of your student ID card.' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upload Form for Rejected -->
                    <form method="POST" action="{{ route('id-verification.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-[#001f5e] mb-2">Upload Student ID Card (Front)</label>
                            <div class="border-2 border-dashed border-[#c8d2e8] rounded-xl p-8 text-center hover:border-[#003087] transition group bg-[#f4f6fb]">
                                <input type="file" name="id_photo" accept="image/*" required class="hidden" id="idPhotoRejected">
                                <label for="idPhotoRejected" class="cursor-pointer block">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-[#5a6480] group-hover:text-[#003087] transition mb-3 block"></i>
                                    <p class="text-[#5a6480] group-hover:text-[#003087] transition">Click or drag to upload ID card</p>
                                    <p class="text-xs text-[#5a6480] mt-2">JPG, PNG (Max 2MB)</p>
                                </label>
                            </div>
                            @error('id_photo') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full bg-[#003087] hover:bg-[#001f5e] text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Submit for Verification
                        </button>
                    </form>

                <!-- CASE 4: NOT SUBMITTED (Show upload form) -->
                @else
                    <!-- Benefits Box -->
                    <div class="bg-[#eef1f8] rounded-lg p-4 mb-6 border border-[#c8d2e8]">
                        <h3 class="font-semibold text-[#001f5e] mb-2 flex items-center gap-2">
                            <i class="fas fa-check-circle text-[#2e7d32]"></i> After verification, you can:
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-tag text-[#C8960C] w-4"></i> Sell items</div>
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-shopping-cart text-[#C8960C] w-4"></i> Buy items</div>
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-comment text-[#C8960C] w-4"></i> Message sellers</div>
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-star text-[#C8960C] w-4"></i> Rate sellers</div>
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-heart text-[#C8960C] w-4"></i> Save favorites</div>
                            <div class="flex items-center gap-2 text-sm text-[#5a6480]"><i class="fas fa-shield-alt text-[#C8960C] w-4"></i> Trusted badge</div>
                        </div>
                    </div>
                    
                    <!-- Upload Form -->
                    <form method="POST" action="{{ route('id-verification.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-[#001f5e] mb-2">Upload Student ID Card (Front)</label>
                            <div class="border-2 border-dashed border-[#c8d2e8] rounded-xl p-8 text-center hover:border-[#003087] transition group bg-[#f4f6fb]">
                                <input type="file" name="id_photo" accept="image/*" required class="hidden" id="idPhoto">
                                <label for="idPhoto" class="cursor-pointer block">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-[#5a6480] group-hover:text-[#003087] transition mb-3 block"></i>
                                    <p class="text-[#5a6480] group-hover:text-[#003087] transition">Click or drag to upload ID card</p>
                                    <p class="text-xs text-[#5a6480] mt-2">JPG, PNG (Max 2MB)</p>
                                </label>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <i class="fas fa-info-circle text-[#C8960C] text-xs"></i>
                                <p class="text-xs text-[#5a6480]">Please upload a clear photo of your student ID. Only .jpg and .png files are accepted.</p>
                            </div>
                            @error('id_photo') <p class="mt-1 text-sm text-[#c0392b]">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="bg-[#eef1f8] rounded-lg p-3 mb-5">
                            <p class="text-xs text-[#5a6480] flex items-center gap-2">
                                <i class="fas fa-info-circle text-[#003087]"></i>
                                Until verified, you can only browse listings. Selling, buying, and messaging require ID verification.
                            </p>
                        </div>
                        
                        <button type="submit" class="w-full bg-[#003087] hover:bg-[#001f5e] text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Submit for Verification
                        </button>
                    </form>
                @endif
                
                <!-- Privacy Note -->
                <div class="mt-6 pt-4 border-t border-[#c8d2e8]">
                    <p class="text-xs text-[#5a6480] text-center flex items-center justify-center gap-1">
                        <i class="fas fa-lock text-[#003087]"></i> Your ID is encrypted and only visible to admins. We take your privacy seriously.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endsection