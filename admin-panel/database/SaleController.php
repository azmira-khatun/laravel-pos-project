<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(15);
        return view('pages.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'        => 'nullable|exists:customers,id',
            'invoice_no'         => 'required|string|max:100|unique:sales,invoice_no',
            'sale_date'          => 'required|date',
            'total_amount'       => 'required|numeric|min:0',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'type'               => 'required|string|in:sale,sale_return',
        ]);

        DB::transaction(function() use ($request) {
            $sale = Sale::create([
                'customer_id'    => $request->customer_id,
                'invoice_no'     => $request->invoice_no,
                'sale_date'      => $request->sale_date,
                'total_amount'   => $request->total_amount,
                'payment_status' => $request->payment_status ?? 'pending',
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
                'type'           => $request->type,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($request->type === 'sale') {
                    $product->adjustStock($item['quantity'], 'decrease');
                } elseif ($request->type === 'sale_return') {
                    $product->adjustStock($item['quantity'], 'increase');
                }

                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'product_id'  => $product->id,
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                ]);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded & stock updated!');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('pages.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        return view('pages.sales.edit', compact('sale','products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'invoice_no'   => 'required|string|max:100|unique:sales,invoice_no,' . $sale->id,
            'sale_date'    => 'required|date',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $sale->update($request->only([
            'invoice_no',
            'sale_date',
            'total_amount',
            'payment_status',
            'payment_method',
            'note',
        ]));

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully!');
    }
}
