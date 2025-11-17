<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Customer;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;

class SalesItemController extends Controller
{
    /**
     * Show form to create multi-product sale
     */
    public function create()
    {
        return view('pages.salesitems.create', [
            'customers'       => Customer::all(),
            'products'        => Product::all(),
            'units'           => ProductUnit::all(),
            'paymentMethods'  => PaymentMethod::all(),
            // Undefined variable $discounts সমস্যার সমাধান
            'discounts'       => Discount::all(),
        ]);
    }

    /**
     * Store a multi-product sale
     */
    public function store(Request $request)
    {
        // -----------------------------------------------------
        // 1) Validation (Based on form data, I'm adding validation for new fields)
        // -----------------------------------------------------
        $request->validate([
            'customer_id'            => 'required|exists:customers,id',
            'product_id.*'           => 'required|exists:products,id',
            'productunit_id.*'       => 'required|exists:product_units,id',
            'quantity.*'             => 'required|numeric|min:1',
            'unit_price.*'           => 'required|numeric|min:0',
            'discount_id.*'          => 'nullable|exists:discounts,id', // নতুন যোগ করা
            'batch_no.*'             => 'nullable|string|max:50',      // নতুন যোগ করা
            'description'            => 'nullable|string|max:255',      // Sale Header এর জন্য
            'payment_method_id'      => 'required|exists:payment_methods,id',
            'payment_status'         => 'required|in:Paid,Due',
            'paid_amount'            => 'required|numeric|min:0',
            // Header Level Financials (form থেকে আসছে)
            'discount_amount_header' => 'nullable|numeric|min:0',
            'tax_amount_header'      => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // -----------------------------------------------------
            // 2) Calculate totals (Using Header and Item values)
            // -----------------------------------------------------

            $subtotal = 0;
            // Calculate item subtotal
            foreach ($request->quantity as $i => $qty) {
                $subtotal += $qty * $request->unit_price[$i];
            }

            // Assuming 'shipping_cost' is 0 if not present in the simplified form
            $shipping = $request->shipping_cost ?? 0;

            // Using Header Level Discount and Tax for Sale Header
            $discount = $request->discount_amount_header ?? 0;
            $tax      = $request->tax_amount_header ?? 0;

            $total_cost = $subtotal - $discount + $tax + $shipping;
            $due_amount = $total_cost - $request->paid_amount;


            // -----------------------------------------------------
            // 3) Create Sale (Header)
            // -----------------------------------------------------

            $sale = Sale::create([
                'customer_id'       => $request->customer_id,
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'paid_amount'       => $request->paid_amount,
                'sell_date'         => now(),

                // New: Add description to Sale header if available
                'description'       => $request->description,

                'subtotal_amount'   => $subtotal,
                'discount_amount'   => $discount, // Header Discount
                'tax_amount'        => $tax,      // Header Tax
                'shipping_cost'     => $shipping,
                'total_cost'        => $total_cost,
                'due_amount'        => $due_amount,
            ]);


            // -----------------------------------------------------
            // 4) Insert Sales Items
            // -----------------------------------------------------

            foreach ($request->product_id as $i => $product_id) {

                $quantity       = $request->quantity[$i];
                $unit_price     = $request->unit_price[$i];
                $productunit_id = $request->productunit_id[$i];
                $line_total     = $quantity * $unit_price;

                SalesItem::create([
                    'sale_id'           => $sale->id,
                    'product_id'        => $product_id,
                    'productunit_id'    => $productunit_id,
                    'quantity'          => $quantity,
                    'unit_price'        => $unit_price,
                    'line_total'        => $line_total,

                    // New fields from the form
                    'discount_id'       => $request->discount_id[$i] ?? null,
                    'batch_no'          => $request->batch_no[$i] ?? null,
                    'expiry_date'       => $request->expiry_date[$i] ?? null,

                    // Default values
                    'discount_amount'   => 0, // Should be calculated if discount_id is set
                    'tax_amount'        => 0, // Should be calculated based on tax rate if necessary
                    'total_cost'        => $line_total, // Line total cost
                    'status'            => 'active',
                ]);

                // Reduce stock
                DB::table('stocks')
                    ->where('product_id', $product_id)
                    ->decrement('quantity', $quantity);
            }

            DB::commit();

            return redirect()
                ->route('salesitems.index')
                ->with('success', 'Sale created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Production-এ কখনও $e->getMessage() দেখানো উচিত নয়।
            // শুধুমাত্র ডেভেলপমেন্টের জন্য এটি ব্যবহার করুন।
            return back()
                ->with('error', 'Sale creation failed: ' . $e->getMessage());
        }
    }

    /**
     * List all sales items
     */
    // SalesItemController.php

// ...

/**
 * List all sales items
 */
public function index()
{
    // with(['unit']) ব্যবহার করা হয়েছে যাতে n+1 query problem না হয়
    $items = SalesItem::with(['sale', 'product', 'unit'])
        ->orderBy('id', 'desc')
        ->paginate(20);

    return view('pages.salesitems.index', compact('items'));
}
}
