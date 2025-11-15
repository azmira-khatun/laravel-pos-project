<?php

namespace App\Http\Controllers;

use App\Models\ExpiredProduct;
use App\Models\Product;   // ← added
use App\Models\User;      // ← added
use Illuminate\Http\Request;

class ExpiredProductController extends Controller
{
    public function index()
    {
        $expiredProducts = ExpiredProduct::with(['product', 'user'])->paginate(10);
        return view('pages.expired_products.index', compact('expiredProducts'));
    }

    public function create()
    {
        $products = Product::all();
        $users    = User::all();
        return view('pages.expired_products.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'expiry_date'=> 'required|date',
            'user_id'    => 'nullable|exists:users,id',
            'noted_on'   => 'nullable|date',
        ]);

        ExpiredProduct::create($request->only(['product_id','expiry_date','user_id','noted_on']));

        return redirect()->route('expiredProductsIndex')
                         ->with('success', 'Expired product record created.');
    }

    public function show(ExpiredProduct $expiredProduct)
    {
        return view('pages.expired_products.show', compact('expiredProduct'));
    }

    public function edit(ExpiredProduct $expiredProduct)
    {
        $products = Product::all();
        $users    = User::all();
        return view('pages.expired_products.edit', compact('expiredProduct','products','users'));
    }

    public function update(Request $request, ExpiredProduct $expiredProduct)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'expiry_date'=> 'required|date',
            'user_id'    => 'nullable|exists:users,id',
            'noted_on'   => 'nullable|date',
        ]);

        $expiredProduct->update($request->only(['product_id','expiry_date','user_id','noted_on']));

        return redirect()->route('expiredProductsIndex')
                         ->with('success', 'Expired product record updated.');
    }

    public function destroy(ExpiredProduct $expiredProduct)
    {
        $expiredProduct->delete();

        return redirect()->route('expiredProductsIndex')
                         ->with('success', 'Expired product record deleted.');
    }
}
