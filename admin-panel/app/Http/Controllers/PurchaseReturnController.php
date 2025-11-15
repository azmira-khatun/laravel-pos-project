<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with(['purchase', 'product', 'vendor', 'user'])->get();
        return view('pages.purchase_returns.index', compact('returns'));
    }

    public function create()
    {
        // যদি প্রয়োজন হয়, purchase/product/vendor/user data এনে form দেখাও
        return view('pages.purchase_returns.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
            'return_date' => 'nullable|date',
            'vendor_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $return = PurchaseReturn::create($data);

        return redirect()->route('purchase-returns.index')->with('success', 'Purchase return created successfully.');
    }

    public function show($id)
    {
        $return = PurchaseReturn::with(['purchase', 'product', 'vendor', 'user'])->findOrFail($id);
        return view('pages.purchase_returns.show', compact('return'));
    }

    public function edit($id)
    {
        $return = PurchaseReturn::findOrFail($id);
        return view('pages.purchase_returns.edit', compact('return'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'purchase_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer|min:1',
            'reason' => 'nullable|string',
            'return_date' => 'nullable|date',
            'vendor_id' => 'integer',
            'user_id' => 'integer',
        ]);

        $return = PurchaseReturn::findOrFail($id);
        $return->update($data);

        return redirect()->route('purchase-returns.index')->with('success', 'Purchase return updated successfully.');
    }

    public function destroy($id)
    {
        $return = PurchaseReturn::findOrFail($id);
        $return->delete();
        return redirect()->route('purchase-returns.index')->with('success', 'Purchase return deleted.');
    }
}
