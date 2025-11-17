<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use App\Models\DamageProduct;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product', 'purchase', 'sale','purchaseReturn', 'damage', 'user'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('pages.stock_movements.index', compact('movements'));
    }

    public function create()
    {
        return view('pages.stock_movements.create', [
            'products' => Product::all(),
            'purchases' => Purchase::all(),
            'sales' => Sale::all(),
            'purchaseReturns' => PurchaseReturn::all(),
            'damages' => DamageProduct::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
        ]);

        StockMovement::create([
            'product_id' => $request->product_id,
            'purchase_id' => $request->purchase_id,
            'sale_id' => $request->sale_id,
            'purchase_return_id' => $request->purchase_return_id,
            'damage_id' => $request->damage_id,
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
            'movement_date' => now(),
        ]);

        return redirect()->route('stockMovements.index')->with('success', 'Stock movement added successfully.');
    }

    public function show(StockMovement $stockMovement)
    {
        return view('pages.stock_movements.show', compact('stockMovement'));
    }
}
