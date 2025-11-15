<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
  public function index()
{
    // সেলসগুলো relation সহ নিয়ে আসুন, এবং pagination দিন
    $sales = Sale::with(['customer', 'product', 'productUnit'])
                 ->orderBy('sell_date', 'desc')
                 ->paginate(10);  // প্রতি পেজে ১০টি রেকর্ড

    return view('pages.sales.index', compact('sales'));
}


    public function create()
    {
        // এখানে আপনি প্রয়োজনীয় ড্রপডাউন ডেটা পাঠাতে পারেন (product_units, payment_methods, customers, products)
        return view('pages.sales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'productunit_id'      => 'required|integer|exists:product_units,id',
            'payment_method_id'   => 'required|integer|exists:payment_methods,id',
            'customer_id'         => 'required|integer|exists:customers,id',
            'product_id'          => 'required|integer|exists:products,id|unique:sales,product_id',
            'payment_status'      => 'required|string|max:20',
            'paid_amount'         => 'required|numeric',
            'sell_date'           => 'required|date',
        ]);

        Sale::create($data);

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['productUnit', 'paymentMethod', 'customer', 'product']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'productunit_id'      => 'required|integer|exists:product_units,id',
            'payment_method_id'   => 'required|integer|exists:payment_methods,id',
            'customer_id'         => 'required|integer|exists:customers,id',
            'product_id'          => 'required|integer|exists:products,id|unique:sales,product_id,'.$sale->id,
            'payment_status'      => 'required|string|max:20',
            'paid_amount'         => 'required|numeric',
            'sell_date'           => 'required|date',
        ]);

        $sale->update($data);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
