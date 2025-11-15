<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StockController extends Controller
{
public function index()
{
    // stocks load with product and user
    $stocks = Stock::with(['product', 'user'])->paginate(15);

    return view('pages.stocks.index', compact('stocks'));
}




    public function create()
    {
        $products = Product::all();
        $users = User::all();
        return view('pages.stocks.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:stocks,product_id',
            'quantity'   => 'required|integer|min:0',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        Stock::create($request->only(['product_id','quantity','user_id']));

        return redirect()->route('stockIndex')
                         ->with('success', 'Stock created successfully.');
    }

    public function show(Stock $stock)
    {
        $stock->load(['product','user']);
        return view('pages.stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $products = Product::all();
        $users = User::all();
        return view('pages.stocks.edit', compact('stock','products','users'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:stocks,product_id,'.$stock->id,
            'quantity'   => 'required|integer|min:0',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $stock->update($request->only(['product_id','quantity','user_id']));

        return redirect()->route('stockIndex')
                         ->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('stockIndex')
                         ->with('success', 'Stock deleted successfully.');
    }
}
