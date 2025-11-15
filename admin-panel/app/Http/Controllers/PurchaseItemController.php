<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class PurchaseItemController extends Controller
{
    // Display a paginated list of purchase items
    public function index()
    {
        $items = PurchaseItem::with(['purchase', 'product'])
                             ->orderBy('id', 'desc')
                             ->paginate(10);

        return view('pages.purchase_items.index', compact('items'));
    }

    // Show form to create a new purchase item
    public function create()
    {
        return view('pages.purchase_items.create', [
            'vendors'        => \App\Models\Vendor::all(),
            'products'       => \App\Models\Product::all(),
            'paymentMethods' => PaymentMethod::where('is_active', true)->get(),
            'purchases'      => \App\Models\Purchase::all(),
        ]);
    }

    // Store new purchase items
public function store(Request $request)
{
    DB::beginTransaction();

    try {

        // Create Purchase
        $purchase = \App\Models\Purchase::create([
            'vendor_id'         => $request->vendor_id,
            'payment_method_id' => $request->payment_method_id,
            'subtotal_amount'   => $request->subtotal_amount,
            'discount_amount'   => $request->discount_amount,
            'tax_amount'        => $request->tax_amount,
            'shipping_cost'     => $request->shipping_cost,
            'total_cost'        => $request->total_cost,
            'paid_amount'       => $request->paid_amount,
            'due_amount'        => $request->due_amount,
            'payment_status'    => $request->payment_status,
        ]);

        // Loop all purchase items
        foreach ($request->product_id as $index => $productId) {

            // Create Purchase Item
            PurchaseItem::create([
                'purchase_id'   => $purchase->id,
                'product_id'    => $productId,
                'quantity'      => $request->quantity[$index],
                'unit_price'    => $request->unit_price[$index],
                'line_discount' => $request->line_discount[$index] ?? 0,
                'line_total'    => $request->line_total[$index],
            ]);

            // --- AUTO STOCK UPDATE HERE ---
            Stock::updateOrCreate(
                ['product_id' => $productId], // find by product
                [
                    'quantity' => DB::raw('quantity + '.$request->quantity[$index]),
                    'user_id'  => auth()->id(),
                ]
            );
        }

        DB::commit();
        return redirect()->route('purchase_items.index')->with('success', 'Purchase created & stock updated.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}


    // Show a single purchase item
    public function show(PurchaseItem $purchaseItem)
    {
        return view('pages.purchase_items.show', compact('purchaseItem'));
    }

    // Show form to edit a purchase item
    public function edit(PurchaseItem $purchaseItem)
    {
        return view('pages.purchase_items.edit', [
            'purchaseItem'   => $purchaseItem,
            'vendors'        => \App\Models\Vendor::all(),
            'products'       => \App\Models\Product::all(),
            'paymentMethods' => PaymentMethod::all(),
            'purchases'      => \App\Models\Purchase::all(),
        ]);
    }

    // Update a purchase item
    public function update(Request $request, PurchaseItem $purchaseItem)
    {
        // আপডেট করার জন্যও ভ্যালিডেশন
        $data = $request->validate([
            'purchase_id'   => 'required|integer|exists:purchases,id',
            'product_id'    => 'required|integer|exists:products,id',
            'quantity'      => 'required|numeric|min:0.01',
            'unit_price'    => 'required|numeric|min:0',
            'line_discount' => 'nullable|numeric|min:0',
            'line_total'    => 'required|numeric|min:0',
        ]);

        $purchaseItem->update($data);

        return redirect()->route('purchase_items.index')
                         ->with('success', 'Purchase item আপডেট সফল হয়েছে।');
    }

    // Delete a purchase item
    public function destroy(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();

        return redirect()->route('purchase_items.index')
                         ->with('success', 'Purchase item মুছে ফেলা হয়েছে।');
    }
}
