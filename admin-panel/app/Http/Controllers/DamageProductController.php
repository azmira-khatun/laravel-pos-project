<?php

namespace App\Http\Controllers;

use App\Models\DamageProduct;
use Illuminate\Http\Request;

class DamageProductController extends Controller
{
    public function index()
    {
        $damageProducts = DamageProduct::with(['product', 'user'])->get();
        return view('pages.damage_products.index', compact('damageProducts'));
    }

    public function create()
    {
        return view('pages.damage_products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:200',
            'user_id' => 'required|exists:users,id',
            'noted_on' => 'nullable|date',
        ]);

        DamageProduct::create($request->all());

        return redirect()->route('damage_products.index')
            ->with('success', 'Damage product recorded successfully.');
    }

    public function show(DamageProduct $damageProduct)
    {
        return view('pages.damage_products.show', compact('damageProduct'));
    }

    public function edit(DamageProduct $damageProduct)
    {
        return view('pages.damage_products.edit', compact('damageProduct'));
    }

    public function update(Request $request, DamageProduct $damageProduct)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:200',
            'user_id' => 'required|exists:users,id',
            'noted_on' => 'nullable|date',
        ]);

        $damageProduct->update($request->all());

        return redirect()->route('damage_products.index')
            ->with('success', 'Damage product updated successfully.');
    }

    public function destroy(DamageProduct $damageProduct)
    {
        $damageProduct->delete();

        return redirect()->route('damage_products.index')
            ->with('success', 'Damage product deleted successfully.');
    }
}
