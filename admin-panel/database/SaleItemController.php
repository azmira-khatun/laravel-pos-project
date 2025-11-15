<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleItemController extends Controller
{
    /**
     * Show all items of a given sale.
     */
    public function index(Sale $sale)
    {
        // Eager load products
        $sale->load('items.product');

        return view('pages.sales.items.index', compact('sale'));
    }

    /**
     * Show the form for adding a new item to a sale.
     */
    public function create(Sale $sale)
    {
        $products = Product::all();
        return view('pages.sales.items.create', compact('sale', 'products'));
    }

    /**
     * Store a new sale item and update product stock.
     */
    public function store(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'type' => 'required|string|in:sale_item,return_item',
        ]);

        DB::transaction(function () use ($request, $sale) {
            $product = Product::findOrFail($request->product_id);

            if ($request->type === 'sale_item') {
                $product->adjustStock($request->quantity, 'decrease');
            } elseif ($request->type === 'return_item') {
                $product->adjustStock($request->quantity, 'increase');
            }

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->quantity * $request->unit_price,
            ]);
        });

        return redirect()->route('sales.items.index', $sale)
            ->with('success', 'Item processed and stock updated!');
    }

    /**
     * Show the form to edit a sale item.
     */
    public function edit(Sale $sale, SaleItem $item)
    {
        $products = Product::all();
        return view('pages.sales.items.edit', compact('sale', 'item', 'products'));
    }

    /**
     * Update a sale item.
     */
    public function update(Request $request, Sale $sale, SaleItem $item)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $item) {
            $oldQuantity = $item->quantity;
            $product = Product::findOrFail($request->product_id);

            // Adjust stock: first restore old quantity, then subtract new quantity
            $product->adjustStock($oldQuantity, 'increase');  // restore
            $product->adjustStock($request->quantity, 'decrease'); // subtract new

            $item->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price' => $request->quantity * $request->unit_price,
            ]);
        });

        return redirect()->route('sales.items.index', $sale)
            ->with('success', 'Item updated successfully!');
    }

    /**
     * Delete a sale item and restore stock.
     */
    public function destroy(Sale $sale, SaleItem $item)
    {
        DB::transaction(function () use ($item) {
            $product = Product::findOrFail($item->product_id);
            $product->adjustStock($item->quantity, 'increase'); // restore stock
            $item->delete();
        });

        return redirect()->route('sales.items.index', $sale)
            ->with('success', 'Item removed and stock restored!');
    }
}
