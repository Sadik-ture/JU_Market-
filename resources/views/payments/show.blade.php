@extends('layouts.app-new')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    <div class="absolute top-20 right-10 w-72 h-72 bg-green-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-3xl mx-auto relative z-10" data-aos="fade-up">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center floating">
                    <i class="fas fa-credit-card text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">Complete Payment</h2>
            <p class="text-gray-400 mt-2">Secure payment via Chapa Gateway</p>
        </div>
        
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl shadow-2xl border border-slate-700">
            <div class="p-8">
                
                <!-- Order Summary -->
                <div class="bg-slate-900 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-400">Order Summary</p>
                            <p class="font-semibold text-white">{{ $listing->title }}</p>
                            <p class="text-sm text-gray-500">Seller: {{ $listing->user->name }}</p>
                        </div>
                        <p class="text-2xl font-bold text-blue-500">ETB {{ number_format($listing->price, 2) }}</p>
                    </div>
                </div>

                <!-- Payment Form -->
                <form method="POST" action="{{ route('payment.initialize', $listing) }}" id="paymentForm">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                        </label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required
                               class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white transition">
                        <p class="text-xs text-gray-500 mt-1">Payment receipt will be sent to this email</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-blue-500"></i>Phone Number
                        </label>
                        <input type="tel" name="phone" placeholder="09XXXXXXXX" required
                               class="w-full px-4 py-3 bg-slate-900 border border-slate-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white transition">
                        <p class="text-xs text-gray-500 mt-1">For payment confirmation via SMS</p>
                    </div>

                    <!-- Payment Methods -->
                    <div class="bg-slate-900 rounded-xl p-4 mb-6">
                        <h4 class="font-semibold text-white mb-3">Supported Payment Methods:</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 text-gray-300"><i class="fas fa-check-circle text-green-500"></i> Telebirr</div>
                            <div class="flex items-center gap-2 text-gray-300"><i class="fas fa-check-circle text-green-500"></i> CBEBirr</div>
                            <div class="flex items-center gap-2 text-gray-300"><i class="fas fa-check-circle text-green-500"></i> eBirr</div>
                            <div class="flex items-center gap-2 text-gray-300"><i class="fas fa-check-circle text-green-500"></i> Credit/Debit Card</div>
                        </div>
                    </div>

                    @php
                        $chapaKey = env('CHAPA_SECRET_KEY');
                        $isTestMode = !$chapaKey || $chapaKey === 'your_test_secret_key_here';
                    @endphp

                    @if($isTestMode)
                        <div class="bg-blue-500/10 border border-blue-500 rounded-xl p-4 mb-6">
                            <p class="text-sm text-blue-400 flex items-center gap-2"><i class="fas fa-flask"></i> <strong>Test Mode Active:</strong> No real payment will be processed.</p>
                        </div>
                    @else
                        <div class="bg-yellow-500/10 border border-yellow-500 rounded-xl p-4 mb-6">
                            <p class="text-sm text-yellow-400 flex items-center gap-2"><i class="fas fa-shield-alt"></i> <strong>Secure Payment:</strong> You'll be redirected to Chapa's secure page.</p>
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <button type="submit" id="payButton" class="btn-primary flex-1 py-3 rounded-xl font-semibold text-lg hover:scale-[1.02] transition">
                            Pay ETB {{ number_format($listing->price, 2) }}
                        </button>
                        <a href="{{ route('listings.show', $listing) }}" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white py-3 rounded-xl font-semibold text-center transition">
                            Cancel
                        </a>
                    </div>
                </form>

                @if($isTestMode)
                    <div class="mt-4 pt-4 border-t border-slate-700">
                        <form method="POST" action="{{ route('payment.test', $listing) }}">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-500/20 border border-yellow-500 text-yellow-400 py-3 rounded-xl font-semibold hover:bg-yellow-500/30 transition">
                                🧪 Test Mode (Skip Real Payment)
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 text-center mt-2">Test mode bypasses Chapa - instantly marks as sold</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
        const payButton = document.getElementById('payButton');
        if (payButton) {
            payButton.disabled = true;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        }
    });
</script>
@endsection