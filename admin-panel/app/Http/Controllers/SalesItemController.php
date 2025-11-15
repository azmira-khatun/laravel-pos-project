<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    public function index()
    {
        $items = SalesItem::with(['sale','product','productUnit','discount'])
                          ->orderBy('id','desc')
                          ->paginate(15);

        return view('pages.sales_items.index', compact('items'));
    }

    public function create()
    {
        // Load data for dropdowns (products, units, discounts, sales list)
        return view('pages.sales_items.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id'         => 'required|integer|exists:sales,id',
            'product_id'      => 'required|integer|exists:products,id',
            'productunit_id'  => 'required|integer|exists:product_units,id',
            'quantity'        => 'required|integer|min:1',
            'unit_price'      => 'required|numeric',
            'discount_id'     => 'nullable|integer|exists:discounts,id',
            'discount_amount' => 'nullable|numeric',
            'line_total'      => 'required|numeric',
        ]);

        SalesItem::create($data);

        return redirect()->route('salesItems.index')->with('success', 'Sales item created successfully.');
    }

    public function show(SalesItem $salesItem)
    {
        return view('pages.sales_items.show', compact('salesItem'));
    }

    public function edit(SalesItem $salesItem)
    {
        return view('pages.sales_items.edit', compact('salesItem'));
    }

    public function update(Request $request, SalesItem $salesItem)
    {
        $data = $request->validate([
            'sale_id'         => 'required|integer|exists:sales,id',
            'product_id'      => 'required|integer|exists:products,id',
            'productunit_id'  => 'required|integer|exists:product_units,id',
            'quantity'        => 'required|integer|min:1',
            'unit_price'      => 'required|numeric',
            'discount_id'     => 'nullable|integer|exists:discounts,id',
            'discount_amount' => 'nullable|numeric',
            'line_total'      => 'required|numeric',
        ]);

        $salesItem->update($data);

        return redirect()->route('salesItems.index')->with('success', 'Sales item updated successfully.');
    }

    public function destroy(SalesItem $salesItem)
    {
        $salesItem->delete();

        return redirect()->route('salesItems.index')->with('success', 'Sales item deleted successfully.');
    }
}
