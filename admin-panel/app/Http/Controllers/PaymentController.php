<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['sale', 'purchase', 'paymentMethod', 'user'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view('payments.create', [
            'sales' => Sale::all(),
            'purchases' => Purchase::all(),
            'methods' => PaymentMethod::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric',
        ]);

        Payment::create([
            'sale_id' => $request->sale_id,
            'purchase_id' => $request->purchase_id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date ?? now(),
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment added successfully.');
    }
}
