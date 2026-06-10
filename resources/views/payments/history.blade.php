@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#003087]/10 rounded-full mb-4">
                <i class="fas fa-receipt text-[#C8960C] text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#001f5e]">Transaction History</h2>
            <p class="text-[#5a6480] mt-1">View all your payments and receipts</p>
        </div>
        
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            @if(isset($payments) && $payments->count() > 0)
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#eef1f8] border-b border-[#c8d2e8]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#5a6480] uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#5a6480] uppercase tracking-wider">Item</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#5a6480] uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#5a6480] uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#5a6480] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#c8d2e8]">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-[#f4f6fb] transition">
                                    <td class="px-6 py-4 text-sm text-[#5a6480] whitespace-nowrap">
                                        <i class="fas fa-calendar-alt text-[#C8960C] text-xs mr-1"></i>
                                        {{ $payment->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('listings.show', $payment->listing) }}" class="text-[#003087] hover:text-[#C8960C] transition font-medium">
                                            {{ Str::limit($payment->listing->title, 35) }}
                                        </a>
                                        <p class="text-xs text-[#5a6480] mt-0.5">Transaction ID: {{ Str::limit($payment->transaction_id, 12) }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-[#003087] text-lg">ETB {{ number_format($payment->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($payment->status == 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#2e7d32]/10 text-[#2e7d32] rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle text-xs"></i> Completed
                                            </span>
                                        @elseif($payment->status == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#C8960C]/10 text-[#C8960C] rounded-full text-xs font-semibold">
                                                <i class="fas fa-clock text-xs"></i> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#c0392b]/10 text-[#c0392b] rounded-full text-xs font-semibold">
                                                <i class="fas fa-times-circle text-xs"></i> {{ ucfirst($payment->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('messages.start', $payment->listing) }}" class="inline-flex items-center gap-1.5 text-[#003087] hover:text-[#C8960C] text-sm transition">
                                            <i class="fas fa-comment"></i> Message Seller
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-[#c8d2e8] bg-white">
                    {{ $payments->links() }}
                </div>
                
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-[#eef1f8] rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-receipt text-[#5a6480] text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-[#001f5e] mb-2">No payment history yet</h3>
                        <p class="text-[#5a6480] mb-6">You haven't made any purchases yet.</p>
                        <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-store"></i> Start Shopping
                        </a>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection