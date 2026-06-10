@extends('layouts.app-new')

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#001f5e]">Payment Transactions</h1>
                <p class="text-[#5a6480] mt-1">Monitor all payment activity</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm px-4 py-2 border border-[#c8d2e8]">
                <span class="text-sm text-[#5a6480]">Total:</span>
                <span class="text-xl font-bold text-[#003087] ml-2">{{ number_format($payments->total()) }}</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-[#c8d2e8] overflow-hidden">
            
            <!-- Filter -->
            <div class="p-5 border-b border-[#c8d2e8]">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-[#5a6480] mb-2">
                            <i class="fas fa-filter mr-1"></i> Payment Status
                        </label>
                        <select name="status" class="w-full px-4 py-2.5 bg-[#f4f6fb] border border-[#c8d2e8] rounded-lg focus:border-[#003087] text-[#1a1f36] transition">
                            <option value="">All Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-[#003087] hover:bg-[#001f5e] text-white px-6 py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-search mr-2"></i>Apply
                        </button>
                        <a href="{{ route('admin.payments') }}" class="bg-[#eef1f8] hover:bg-[#c8d2e8] text-[#003087] px-6 py-2.5 rounded-lg font-semibold transition">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Payments Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#eef1f8]">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Item</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Buyer</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Seller</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Amount</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Transaction ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-[#5a6480]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#c8d2e8]">
                        @forelse($payments as $payment)
                        <tr class="hover:bg-[#f4f6fb] transition">
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('listings.show', $payment->listing) }}" class="text-[#003087] hover:text-[#C8960C] transition font-medium">
                                    {{ Str::limit($payment->listing->title ?? 'N/A', 25) }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $payment->buyer->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-[#5a6480] text-sm">{{ $payment->seller->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 font-semibold text-[#2e7d32]">ETB {{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-mono text-[#5a6480] bg-[#eef1f8] px-2 py-1 rounded">{{ Str::limit($payment->transaction_id, 16) }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                                    @if($payment->status == 'completed') bg-[#2e7d32]/10 text-[#2e7d32]
                                    @elseif($payment->status == 'pending') bg-[#C8960C]/10 text-[#C8960C]
                                    @elseif($payment->status == 'failed') bg-[#c0392b]/10 text-[#c0392b]
                                    @else bg-[#5a6480]/10 text-[#5a6480]
                                    @endif">
                                    <i class="fas fa-circle text-[6px]"></i>
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-[#5a6480]">
                                <i class="fas fa-receipt text-4xl mb-3 block"></i>
                                <p>No payment transactions found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-5 border-t border-[#c8d2e8]">
                {{ $payments->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection