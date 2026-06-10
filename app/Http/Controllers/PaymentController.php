<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // Show payment form
    public function show(Listing $listing)
    {
        if ($listing->user_id === auth()->id()) {
            return back()->with('error', 'You cannot buy your own item.');
        }

        if ($listing->status === 'Sold') {
            return back()->with('error', 'This item has already been sold.');
        }

        return view('payments.show', compact('listing'));
    }

    // Initialize payment with Chapa API
    public function initialize(Request $request, Listing $listing)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $chapaKey = env('CHAPA_SECRET_KEY');

        // If no Chapa key, use test mode
        if (! $chapaKey || $chapaKey === 'your_test_secret_key_here') {
            return $this->testMode($listing);
        }

        // Generate unique reference
        $tx_ref = 'CAMPUS_'.Str::random(10).'_'.time();

        // Clean title for Chapa
        $cleanTitle = substr(preg_replace('/[^a-zA-Z0-9\s]/', '', $listing->title), 0, 16);

        // Payment data
        $data = [
            'amount' => (float) $listing->price,
            'currency' => 'ETB',
            'email' => $request->email,
            'first_name' => auth()->user()->name,
            'phone_number' => $request->phone,
            'tx_ref' => $tx_ref,
            'callback_url' => route('payment.callback', $tx_ref),
            'return_url' => route('payment.callback', $tx_ref),
            'customization' => [
                'title' => $cleanTitle ?: 'Purchase',
            ],
        ];

        try {
            // Make API call to Chapa
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$chapaKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.chapa.co/v1/transaction/initialize', $data);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['status'] === 'success' && isset($responseData['data']['checkout_url'])) {
                    // Save payment record as pending
                    Payment::create([
                        'buyer_id' => auth()->id(),
                        'seller_id' => $listing->user_id,
                        'listing_id' => $listing->id,
                        'amount' => $listing->price,
                        'currency' => 'ETB',
                        'tx_ref' => $tx_ref,
                        'transaction_id' => $responseData['data']['reference'] ?? $tx_ref,
                        'status' => 'pending',
                    ]);

                    // Redirect to Chapa payment page
                    return redirect($responseData['data']['checkout_url']);
                }
            }

            // If something went wrong, use test mode
            return $this->testMode($listing);

        } catch (\Exception $e) {
            // On error, use test mode
            return $this->testMode($listing);
        }
    }

    // TEST MODE - Simulate successful payment
    public function testMode(Listing $listing)
    {
        if ($listing->status === 'Sold') {
            return redirect()->route('listings.show', $listing)
                ->with('error', 'This item has already been sold.');
        }

        $tx_ref = 'TEST_'.Str::random(10).'_'.time();

        $payment = Payment::create([
            'buyer_id' => auth()->id(),
            'seller_id' => $listing->user_id,
            'listing_id' => $listing->id,
            'amount' => $listing->price,
            'currency' => 'ETB',
            'tx_ref' => $tx_ref,
            'transaction_id' => 'TEST_'.$tx_ref,
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        $listing->update([
            'status' => 'Sold',
            'sold_to_user_id' => auth()->id(),
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', '✅ TEST MODE: Payment successful! You have purchased "'.$listing->title.'".');
    }

    // Handle payment callback from Chapa
    public function callback($reference)
    {
        $chapaKey = env('CHAPA_SECRET_KEY');

        // Check if test mode payment
        if (str_starts_with($reference, 'TEST_')) {
            $payment = Payment::where('tx_ref', $reference)->first();
            if ($payment && $payment->status === 'completed') {
                return redirect()->route('listings.show', $payment->listing_id)
                    ->with('success', '✅ Payment successful! You have purchased this item.');
            }

            return redirect()->route('dashboard')->with('error', 'Payment not found.');
        }

        if (! $chapaKey || $chapaKey === 'your_test_secret_key_here') {
            $payment = Payment::where('tx_ref', $reference)->first();
            if ($payment) {
                return redirect()->route('listings.show', $payment->listing_id)
                    ->with('success', '✅ Payment successful!');
            }

            return redirect()->route('dashboard')->with('error', 'Chapa not configured.');
        }

        $verifyUrl = 'https://api.chapa.co/v1/transaction/verify/'.$reference;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$chapaKey,
            ])->get($verifyUrl);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'success') {
                    $payment = Payment::where('tx_ref', $reference)->first();

                    if ($payment && $payment->status === 'pending') {
                        DB::transaction(function () use ($payment) {
                            $payment->update([
                                'status' => 'completed',
                                'paid_at' => now(),
                            ]);

                            $payment->listing->update([
                                'status' => 'Sold',
                                'sold_to_user_id' => $payment->buyer_id,
                            ]);
                        });

                        return redirect()->route('listings.show', $payment->listing_id)
                            ->with('success', '✅ Payment successful! You have purchased this item.');
                    }
                }
            }

            $payment = Payment::where('tx_ref', $reference)->first();
            if ($payment && $payment->status === 'completed') {
                return redirect()->route('listings.show', $payment->listing_id)
                    ->with('success', '✅ Payment successful!');
            }

            return redirect()->route('dashboard')
                ->with('error', 'Payment verification failed.');

        } catch (\Exception $e) {
            $payment = Payment::where('tx_ref', $reference)->first();
            if ($payment && $payment->status === 'completed') {
                return redirect()->route('listings.show', $payment->listing_id)
                    ->with('success', '✅ Payment successful!');
            }

            return redirect()->route('dashboard')
                ->with('error', 'Verification error: '.$e->getMessage());
        }
    }

    // Show receipt
    public function receipt(Payment $payment)
    {
        if ($payment->buyer_id !== auth()->id() && $payment->seller_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.receipt', compact('payment'));
    }

    // Payment history
    public function history()
    {
        $payments = Payment::where('buyer_id', auth()->id())
            ->orWhere('seller_id', auth()->id())
            ->with(['listing', 'buyer', 'seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('payments.history', compact('payments'));
    }
}
