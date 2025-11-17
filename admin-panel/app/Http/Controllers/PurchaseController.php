<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ProductUnit;
use App\Models\PaymentMethod;
use App\Models\User; // 💡 পরিবর্তন: User মডেলটি আমদানি করা হলো
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{


public function index()
{
    // Get all purchases, latest first, with vendor & product relationships
    $purchases = \App\Models\Purchase::with(['vendor', 'product'])
                        ->orderBy('id', 'desc')
                        ->paginate(10); // optional pagination

    return view('pages.purchases.index', compact('purchases'));
}

    /**
     * Show create purchase page (multiple products)
     */
    public function create()
    {
        return view('pages.purchases.create', [
            'vendors' => Vendor::all(),
            'products' => Product::all(),
            'units' => ProductUnit::all(),
            'paymentMethods' => PaymentMethod::all(),
            'users' => User::all() // 💡 পরিবর্তন: $users ভ্যারিয়েবলটি ভিউতে পাস করা হলো
        ]);
    }

    /**
     * Store purchase + multiple purchase items
     */
   public function store(Request $request)
    {
        // 1. Validation (Header ও Item উভয় ক্ষেত্রেই)
        $request->validate([
            'vendor_id'         => 'required|integer|exists:vendors,id',
            'user_id'           => 'nullable|integer|exists:users,id', // users table এর বিপরীতে validation যোগ করা হলো
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'payment_status'    => 'required|string',
            'purchase_date'     => 'nullable|date',
            'receive_date'      => 'nullable|date',

            // Header Totals (Ensure these are present, even if 0 from form)
            'subtotal_amount'   => 'required|numeric|min:0', // create.blade.php থেকে আসা উচিত
            'discount_amount'   => 'nullable|numeric|min:0',
            'tax_amount'        => 'nullable|numeric|min:0',
            'shipping_cost'     => 'nullable|numeric|min:0',
            'total_cost'        => 'required|numeric|min:0',   // create.blade.php থেকে আসা উচিত
            'paid_amount'       => 'nullable|numeric|min:0',
            'due_amount'        => 'required|numeric|min:0',   // create.blade.php থেকে আসা উচিত

            // 💡 Single Item Validation based on create.blade.php
            'product_id'        => 'required|integer|exists:products,id',
            'productunit_id'    => 'nullable|integer|exists:product_units,id',
            'quantity'          => 'required|numeric|min:1',
            'unit_price'        => 'required|numeric|min:0',
            'line_discount'     => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // -----------------------------------------------------
            // 2. Prepare Data for Header (Purchase)
            // -----------------------------------------------------
            // যেহেতু টোটালগুলো ফর্ম থেকে আসছে, তাই সেগুলো ব্যবহার করুন।
            // ফর্ম থেকে না এলে 0 সেট করুন।
            $discount   = $request->discount_amount ?? 0;
            $tax        = $request->tax_amount ?? 0;
            $shipping   = $request->shipping_cost ?? 0;
            $paidAmount = $request->paid_amount ?? 0;

            // 💡 Validation অনুযায়ী subtotal, total_cost, due_amount লাগবে
            $subtotal_amount = $request->subtotal_amount;
            $total_cost      = $request->total_cost;
            $due_amount      = $request->due_amount;


            // -----------------------------------------------------
            // 3. Create Purchase (Header)
            // -----------------------------------------------------
            $purchase = Purchase::create([
                'vendor_id'         => $request->vendor_id,
                // user_id সেট করুন, যদি আপনার সেশনে ইউজার লগইন থাকে
                'user_id'           => auth()->id() ?? $request->user_id,
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'purchase_date'     => $request->purchase_date ?? now(),
                'receive_date'      => $request->receive_date,

                // Totals from Form/Calculations
                'subtotal_amount'   => $subtotal_amount,
                'discount_amount'   => $discount,
                'tax_amount'        => $tax,
                'shipping_cost'     => $shipping,
                'total_cost'        => $total_cost,
                'paid_amount'       => $paidAmount,
                'due_amount'        => $due_amount,
            ]);


            // -----------------------------------------------------
            // 4. Create Purchase Item (Single Item Logic)
            // -----------------------------------------------------

            $quantity      = $request->quantity;
            $unitPrice     = $request->unit_price;
            $lineDiscount  = $request->line_discount ?? 0;

            // Item Calculation
            $line_total = ($quantity * $unitPrice) - $lineDiscount;

            // PurchaseItem::create() ব্যবহার করে ডেটা সেভ করুন
            // ⚠️ নিশ্চিত করুন যে আপনার 'purchase_items' টেবিলে 'line_discount' কলামটি আছে।
            PurchaseItem::create([
                'purchase_id'       => $purchase->id,
                'product_id'        => $request->product_id,
                'productunit_id'    => $request->productunit_id ?? null,
                'quantity'          => $quantity,
                'unit_price'        => $unitPrice,
                'line_discount'     => $lineDiscount,
                'line_total'        => $line_total,
                // অন্যান্য ফিল্ড যেমন: tax, batch, expiry যদি থাকে
            ]);

            // 💡 Stock Update (যদি আপনার কাছে stock টেবিল থাকে)
            // DB::table('stocks')
            //      ->where('product_id', $request->product_id)
            //      ->increment('quantity', $quantity);

            DB::commit();

            return redirect()->route('purchases.history')
                ->with('success', 'Purchase created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // ❌ ডেভলপমেন্ট ছাড়া $e->getMessage() দেখানো উচিত নয়।
            // শুধুমাত্র ডেভেলপমেন্টের জন্য এটি ব্যবহার করুন।
            return back()->with('error', 'Purchase creation failed. Error: ' . $e->getMessage());
        }
    }
     public function history()
    {
        // Get all purchases, latest first
        $purchases = Purchase::orderBy('id', 'desc')->paginate(15); // pagination optional

        // Return a view (create resources/views/purchases/history.blade.php)
        return view('pages.purchases.history', compact('purchases'));

        // Or return JSON for API:
        // return response()->json($purchases);
    }
    public function show($id)
{
    // Find the purchase by ID with vendor and product
    $purchase = \App\Models\Purchase::with(['vendor', 'product'])->findOrFail($id);

    // Return a view (create resources/views/purchases/show.blade.php)
    return view('purchases.show', compact('purchase'));

    // If API, you could return JSON instead:
    // return response()->json($purchase);
}


}
