<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Product;   // যদি প্রোডাক্ট রিটার্নের জন্য প্রোডাক্ট সম্পর্ক যুক্ত করতে চান
use App\Models\PurchaseItem; // যদি PurchaseItem মডেল থাকে, যেমন প্রতি প্রোডাক্ট আইটেম

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the purchase returns.
     */
    public function index()
    {
        // eager load purchase and product (optional) to reduce queries
        $returns = PurchaseReturn::with(['purchase', 'product'])->latest()->get();

        return view('pages.purchase_return.index', compact('returns'));
    }

    /**
     * Show the form for creating a new purchase return.
     */
    public function create()
    {
        $purchases = Purchase::with('product')->get(); // যদি প্রতিটি Purchase–এ product থাকে
        $products  = Product::all(); // যদি রিটার্নের সময় প্রোডাক্ট নির্বাচন করতে চান

        return view('pages.purchase_return.create', compact('purchases','products'));
    }

    /**
     * Fetch purchase data (AJAX) for the selected purchase.
     */
    public function fetchPurchaseData(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
        ]);

        $purchase = Purchase::with('items','product')->find($request->purchase_id);

        if (!$purchase) {
            return response()->json(['error' => 'Purchase not found'], 404);
        }

        $totalQuantity    = $purchase->items->sum('quantity');
        $subtotalAmount   = $purchase->subtotal_amount;
        $taxAmount        = $purchase->tax_amount   ?? 0;
        $shippingCost     = $purchase->shipping_cost ?? 0;

        return response()->json([
            'total_quantity'  => $totalQuantity,
            'subtotal_amount' => $subtotalAmount,
            'tax_amount'      => $tax_amount = $taxAmount,
            'shipping_cost'   => $shippingCost,
            'product_id'      => optional($purchase->product)->id,
            'product_name'    => optional($purchase->product)->name,
        ]);
    }

    /**
     * Store a newly created purchase return in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id'     => 'required|exists:purchases,id',
            'product_id'      => 'required|exists:products,id',
            'return_quantity' => 'required|integer|min:1',
            'payment_method'  => 'required|string|max:50',
            'status'          => 'required|string|max:20',
            'note'            => 'nullable|string',
        ]);

        // Fetch main purchase data
        $purchase = Purchase::find($validated['purchase_id']);

        // Compute additional fields
        $totalQuantity  = $request->input('total_quantity', 0);
        $subtotal       = $request->input('subtotal_amount', 0);
        $tax            = $request->input('tax_amount', 0);
        $shipping       = $request->input('shipping_cost', 0);
        $returnQty      = $validated['return_quantity'];

        // Example calculation – আপনি নিজেই ক্যালকুলেশন ঠিক করবেন
        $refundAmount   = ($subtotal / ($totalQuantity ?: 1)) * $returnQty;
        $netRefund      = $refundAmount + $tax + $shipping;

        $data = [
            'purchase_id'      => $validated['purchase_id'],
            'product_id'       => $validated['product_id'],
            'product_name'     => Product::find($validated['product_id'])->name,
            'total_quantity'   => $totalQuantity,
            'subtotal_amount'  => $subtotal,
            'tax_amount'       => $tax,
            'shipping_cost'    => $shipping,
            'return_quantity'  => $returnQty,
            'refund_amount'    => $refundAmount,
            'net_refund'       => $netRefund,
            'payment_method'   => $validated['payment_method'],
            'status'           => $validated['status'],
            'note'             => $validated['note'] ?? null,
        ];

        PurchaseReturn::create($data);

        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return created successfully!');
    }

    /**
     * Display the specified purchase return.
     */
    public function show($id)
    {
        $return = PurchaseReturn::with(['purchase','product'])->findOrFail($id);

        return view('pages.purchase_return.show', compact('return'));
    }

    /**
     * Show the form for editing the specified purchase return.
     */
    public function edit($id)
    {
        $return    = PurchaseReturn::findOrFail($id);
        $purchases = Purchase::all();
        $products  = Product::all();

        return view('pages.purchase_return.edit', compact('return','purchases','products'));
    }

    /**
     * Update the specified purchase return in storage.
     */
    public function update(Request $request, $id)
    {
        $return = PurchaseReturn::findOrFail($id);

        $validated = $request->validate([
            'purchase_id'     => 'required|exists:purchases,id',
            'product_id'      => 'required|exists:products,id',
            'return_quantity' => 'required|integer|min:1',
            'payment_method'  => 'required|string|max:50',
            'status'          => 'required|string|max:20',
            'note'            => 'nullable|string',
        ]);

        // similar calculation logic
        $totalQuantity = $request->input('total_quantity', $return->total_quantity);
        $subtotal      = $request->input('subtotal_amount', $return->subtotal_amount);
        $tax           = $request->input('tax_amount', $return->tax_amount);
        $shipping      = $request->input('shipping_cost', $return->shipping_cost);
        $returnQty     = $validated['return_quantity'];

        $refundAmount = ($subtotal / ($totalQuantity ?: 1)) * $returnQty;
        $netRefund    = $refundAmount + $tax + $shipping;

        $dataUpdate = [
            'purchase_id'     => $validated['purchase_id'],
            'product_id'      => $validated['product_id'],
            'product_name'    => Product::find($validated['product_id'])->name,
            'total_quantity'  => $totalQuantity,
            'subtotal_amount' => $subtotal,
            'tax_amount'      => $tax,
            'shipping_cost'   => $shipping,
            'return_quantity' => $returnQty,
            'refund_amount'   => $refundAmount,
            'net_refund'      => $netRefund,
            'payment_method'  => $validated['payment_method'],
            'status'          => $validated['status'],
            'note'            => $validated['note'] ?? null,
        ];

        $return->update($dataUpdate);

        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return updated successfully!');
    }

    /**
     * Remove the specified purchase return from storage.
     */
    public function destroy($id)
    {
        $return = PurchaseReturn::findOrFail($id);
        $return->delete();

        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return deleted successfully!');
    }
}
