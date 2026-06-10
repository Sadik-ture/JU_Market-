<div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700 overflow-hidden">
    <div class="border-b border-slate-700 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-edit text-blue-400 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Profile Information</h3>
                <p class="text-sm text-gray-400 mt-0.5">Update your account's profile information</p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('patch')
            
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>Full Name
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white transition placeholder-gray-500"
                       placeholder="Enter your full name">
                @error('name') 
                    <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white transition placeholder-gray-500"
                       placeholder="student@university.edu.et">
                @error('email') 
                    <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
                
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3 bg-yellow-500/10 border border-yellow-500/50 rounded-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            <p class="text-sm text-yellow-400">
                                Your email address is unverified.
                                <button form="send-verification" class="underline hover:text-yellow-300 ml-1">Click here to re-send verification email.</button>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2.5 rounded-xl font-semibold transition-all hover:scale-105 flex items-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
            
            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div class="mt-3 p-3 bg-green-500/20 border border-green-500/50 rounded-xl">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400"></i>
                        <p class="text-green-400 text-sm">Profile updated successfully!</p>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>