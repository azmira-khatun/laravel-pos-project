<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductUnit;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Show create purchase page (multiple products)
     */
    public function create()
    {
        return view('pages.purchases.create', [
            'vendors' => Vendor::all(),
            'products' => Product::all(),
            'units' => ProductUnit::all(),
            'paymentMethods' => PaymentMethod::all()
        ]);
    }

    /**
     * Store purchase + multiple purchase items
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id'         => 'required|integer',
            'user_id'           => 'nullable|integer',
            'payment_method_id' => 'required|integer',
            'payment_status'    => 'required|string',
            'purchase_date'     => 'nullable|date',
            'receive_date'      => 'nullable|date',

            // product rows validation
            'product_id.*'      => 'required|integer',
            'quantity.*'        => 'required|numeric',
            'unit_price.*'      => 'required|numeric',
            'line_discount.*'   => 'nullable|numeric',
        ]);

        DB::beginTransaction();

        try {
            // PURCHASE MAIN
            $purchase = Purchase::create([
                'vendor_id'         => $request->vendor_id,
                'user_id'           => $request->user_id,
                'subtotal_amount'   => $request->subtotal_amount,
                'discount_amount'   => $request->discount_amount ?? 0,
                'tax_amount'        => $request->tax_amount ?? 0,
                'shipping_cost'     => $request->shipping_cost ?? 0,
                'total_cost'        => $request->total_cost,
                'paid_amount'       => $request->paid_amount ?? 0,
                'due_amount'        => $request->due_amount,
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'purchase_date'     => $request->purchase_date,
                'receive_date'      => $request->receive_date,
            ]);

            // PURCHASE ITEMS
            foreach ($request->product_id as $key => $productId) {
                PurchaseItem::create([
                    'purchase_id'  => $purchase->id,
                    'product_id'   => $productId,
                    'quantity'     => $request->quantity[$key],
                    'unit_price'   => $request->unit_price[$key],
                    'line_discount'=> $request->line_discount[$key] ?? 0,
                    'line_total'   => $request->quantity[$key] * $request->unit_price[$key] - ($request->line_discount[$key] ?? 0),
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.history')
                ->with('success', 'Purchase with multiple items created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

}
