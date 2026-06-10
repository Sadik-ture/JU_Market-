<div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-700 overflow-hidden">
    <div class="border-b border-slate-700 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-lock text-yellow-400 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white">Update Password</h3>
                <p class="text-sm text-gray-400 mt-0.5">Ensure your account is using a secure password</p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')
            
            <!-- Current Password -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-key mr-2 text-yellow-500"></i>Current Password
                </label>
                <input type="password" name="current_password" id="current_password" 
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 text-white transition placeholder-gray-500"
                       placeholder="Enter your current password">
                @error('current_password', 'updatePassword') 
                    <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>
            
            <!-- New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-plus-circle mr-2 text-yellow-500"></i>New Password
                </label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 text-white transition placeholder-gray-500"
                       placeholder="Enter new password">
                @error('password', 'updatePassword') 
                    <p class="mt-1 text-sm text-red-400 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>
            
            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-check-circle mr-2 text-yellow-500"></i>Confirm Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500/20 text-white transition placeholder-gray-500"
                       placeholder="Confirm your new password">
            </div>
            
            <!-- Password Strength Indicator -->
            <div class="hidden" id="passwordStrength">
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex-1 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                        <div id="strengthBar" class="h-full w-0 transition-all duration-300 rounded-full"></div>
                    </div>
                    <span id="strengthText" class="text-xs font-medium"></span>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-amber-600 hover:from-yellow-700 hover:to-amber-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all hover:scale-105 flex items-center gap-2 shadow-lg">
                    <i class="fas fa-key"></i> Update Password
                </button>
            </div>
            
            <!-- Success Message -->
            @if (session('status') === 'password-updated')
                <div class="mt-3 p-3 bg-green-500/20 border border-green-500/50 rounded-xl">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-400"></i>
                        <p class="text-green-400 text-sm">Password updated successfully!</p>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<script>
    // Password Strength Checker
    const passwordInput = document.getElementById('password');
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            if (password.length > 0) {
                strengthDiv.classList.remove('hidden');
                let strength = 0;
                let message = '';
                let color = '';
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                
                if (strength <= 2) {
                    message = 'Weak';
                    color = '#EF4444';
                } else if (strength <= 4) {
                    message = 'Medium';
                    color = '#F59E0B';
                } else {
                    message = 'Strong';
                    color = '#10B981';
                }
                
                strengthBar.style.width = (strength / 5 * 100) + '%';
                strengthBar.style.backgroundColor = color;
                strengthText.textContent = message;
                strengthText.style.color = color;
            } else {
                strengthDiv.classList.add('hidden');
            }
        });
    }
</script>