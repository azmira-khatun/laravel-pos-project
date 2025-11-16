<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Sale;
use App\Models\Discount;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    // ---------------------- INDEX ----------------------
    public function index()
    {
        $items = SalesItem::with(['sale', 'product', 'productUnit', 'discount'])
                          ->orderBy('id', 'desc')
                          ->paginate(15);

        return view('pages.sales_items.index', compact('items'));
    }

    // ---------------------- CREATE ----------------------
    public function create()
    {
        $sales      = Sale::orderBy('id','desc')->get();
        $products   = Product::all();
        $units      = ProductUnit::all();
        $discounts  = Discount::all();

        return view('pages.sales_items.create', compact('sales','products','units','discounts'));
    }

    // ---------------------- STORE ----------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_id'         => 'required|integer|exists:sales,id',
            'product_id'      => 'required|integer|exists:products,id',
            'productunit_id'  => 'required|integer|exists:product_units,id',
            'quantity'        => 'required|integer|min:1',
            'unit_price'      => 'required|numeric|min:0',
            'discount_id'     => 'nullable|integer|exists:discounts,id',
            'discount_amount' => 'nullable|numeric|min:0',
            'line_total'      => 'required|numeric|min:0',
        ]);

        SalesItem::create($data);

        return redirect()->route('salesItems.index')
                         ->with('success', 'Sales item created successfully.');
    }

    // ---------------------- SHOW ----------------------
    public function show(SalesItem $salesItem)
    {
        return view('pages.sales_items.show', compact('salesItem'));
    }

    // ---------------------- EDIT ----------------------
    public function edit(SalesItem $salesItem)
    {
        $sales      = Sale::orderBy('id','desc')->get();
        $products   = Product::all();
        $units      = ProductUnit::all();
        $discounts  = Discount::all();

        return view('pages.sales_items.edit', compact('salesItem','sales','products','units','discounts'));
    }

    // ---------------
}
