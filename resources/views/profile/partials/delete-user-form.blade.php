<div class="bg-red-500/5 backdrop-blur-sm rounded-2xl border border-red-500/30 overflow-hidden">
    <div class="border-b border-red-500/30 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-trash-alt text-red-400 text-lg"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-red-400">Delete Account</h3>
                <p class="text-sm text-gray-400 mt-0.5">Permanently delete your account and all data</p>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="bg-red-500/10 rounded-xl p-4 mb-4 border border-red-500/20">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-red-400 text-lg mt-0.5"></i>
                <div>
                    <p class="text-red-400 text-sm font-medium mb-1">Warning: This action cannot be undone</p>
                    <p class="text-gray-400 text-sm">
                        Once your account is deleted, all of your listings, messages, favorites, and transaction history will be permanently removed from our system.
                    </p>
                </div>
            </div>
        </div>
        
        <p class="text-gray-300 text-sm mb-4">
            Before deleting your account, please ensure you have downloaded any data or information you wish to retain.
        </p>
        
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                class="bg-red-500/20 border border-red-500 text-red-400 px-6 py-2.5 rounded-xl font-semibold hover:bg-red-500/30 hover:scale-105 transition-all inline-flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i> Delete Account
        </button>
    </div>
</div>

<!-- Delete Account Modal -->
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <div class="p-6 bg-slate-800 rounded-2xl">
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Delete Account</h3>
                    <p class="text-sm text-gray-400">This action is permanent</p>
                </div>
            </div>
            
            <p class="text-gray-300 mb-4 text-sm">
                Are you sure you want to delete your account? All your data will be permanently removed from our servers.
            </p>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-lock mr-2 text-red-400"></i>Enter your password to confirm
                </label>
                <input type="password" name="password" placeholder="Your password" required
                       class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-500/20 text-white transition">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            
            <div class="flex gap-3 justify-end">
                <button type="button" x-on:click="$dispatch('close')" 
                        class="px-5 py-2.5 rounded-xl bg-slate-700 text-gray-300 font-medium hover:bg-slate-600 transition-all">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-red-500/20 border border-red-500 text-red-400 font-semibold hover:bg-red-500/30 hover:scale-105 transition-all flex items-center gap-2">
                    <i class="fas fa-trash-alt"></i> Delete Forever
                </button>
            </div>
        </form>
    </div>
</x-modal>