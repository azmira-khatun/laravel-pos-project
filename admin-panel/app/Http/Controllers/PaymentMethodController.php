<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     * Corresponds to route: paymentMethodIndex
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('pages.payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     * Corresponds to route: paymentMethodCreate
     */
    public function create()
    {
        return view('pages.payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     * Corresponds to route: paymentMethodStore
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:50|unique:payment_methods,method_name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // 'is_active' ফিল্ডটি একটি বুলিয়ান এবং স্কিমা অনুযায়ী ডিফল্ট 'true'
        // যদি রিকোয়েস্ট-এ এটি না আসে (যেমন, আনচেকড্), তবে 'true' সেট হবে।
        $validated['is_active'] = $request->boolean('is_active', true);

        PaymentMethod::create($validated);

        return redirect()->route('paymentMethodIndex')
                         ->with('message', 'Payment Method created successfully.');
    }

    /**
     * Display the specified resource.
     * Corresponds to route: paymentMethodShow
     */
    public function show(PaymentMethod $paymentMethod)
    {
        // Route Model Binding (PaymentMethod $paymentMethod)
        return view('pages.payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     * Corresponds to route: paymentMethodEdit
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        // Route Model Binding (PaymentMethod $paymentMethod)
        return view('pages.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     * Corresponds to route: paymentMethodUpdate
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:50|unique:payment_methods,method_name,' . $paymentMethod->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // আপডেটের সময় যদি 'is_active' (আনচেকড্) না আসে, তবে 'false' সেট হবে।
        $validated['is_active'] = $request->boolean('is_active', false);

        $paymentMethod->update($validated);

        return redirect()->route('paymentMethodIndex')
                         ->with('message', 'Payment Method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * Corresponds to route: paymentMethodDelete
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            // Route Model Binding (PaymentMethod $paymentMethod)
            $paymentMethod->delete();
            return redirect()->route('paymentMethodIndex')
                             ->with('message', 'Payment Method deleted successfully.');
        } catch (\Exception $e) {
            // যদি এই মেথডটি অন্য কোনো টেবিলে ব্যবহৃত হয় (Foreign Key Constraint)
            return redirect()->route('paymentMethodIndex')
                             ->with('error', 'Cannot delete payment method: It is linked to existing transactions.');
        }
    }
}
