@extends('layouts.app-new')
@section('content')

        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-2">Payment Complete!</h2>
                <p class="text-gray-600 mb-4">Your transaction has been processed successfully.</p>
                <p class="text-gray-500 mb-6">A receipt has been sent to your email. You can close this window now.</p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('dashboard') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        Go to Dashboard
                    </a>
                    <button onclick="window.close()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                        Close Window
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
