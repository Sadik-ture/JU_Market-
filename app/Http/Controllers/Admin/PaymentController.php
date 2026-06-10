<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['buyer', 'seller', 'listing']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20);
        $statuses = ['pending', 'completed', 'failed', 'refunded'];

        return view('admin.payments', compact('payments', 'statuses'));
    }
}
