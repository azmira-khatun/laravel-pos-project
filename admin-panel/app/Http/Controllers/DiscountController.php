<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the discounts.
     */
    public function index()
    {
        $discounts = Discount::with('product')->get();
        return view('pages.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount.
     */
    public function create()
    {
        $products = Product::all();
        return view('pages.discounts.create', compact('products'));
    }

    /**
     * Store a newly created discount in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name'       => 'required|string|max:100',
            'type'       => 'required|in:percent,fixed',
            'amount'     => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable|in:active,inactive',
        ]);

        Discount::create($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    /**
     * Show the form for editing the specified discount.
     */
    public function edit(Discount $discount)
    {
        $products = Product::all();
        return view('pages.discounts.edit', compact('discount', 'products'));
    }

    /**
     * Update the specified discount in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name'       => 'required|string|max:100',
            'type'       => 'required|in:percent,fixed',
            'amount'     => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable|in:active,inactive',
        ]);

        $discount->update($validated);

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified discount from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
