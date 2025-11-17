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
            'discounts'       => Discount::all(),
        ]);
    }

    /**
     * Store a multi-product sale
     */
    public function store(Request $request)
    {
        // -----------------------------------------------------
        // 1) Validation (Using 'items' array for simplicity and reliability)
        // -----------------------------------------------------
        $request->validate([
            'customer_id'            => 'required|exists:customers,id',
            'payment_method_id'      => 'required|exists:payment_methods,id',
            'payment_status'         => 'required|in:Paid,Due,Partial', // Partial যোগ করা হয়েছে
            'paid_amount'            => 'required|numeric|min:0',
            'description'            => 'nullable|string|max:255',
            'shipping_cost'          => 'nullable|numeric|min:0',

            // Item Array Validation
            'items'                  => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.productunit_id' => 'required|exists:product_units,id',
            'items.*.quantity'       => 'required|numeric|min:1',
            'items.*.unit_price'     => 'required|numeric|min:0',
            'items.*.discount_id'    => 'nullable|exists:discounts,id',
            'items.*.batch_no'       => 'nullable|string|max:50',
            'items.*.expiry_date'    => 'nullable|date',
            // item-level discount/tax calculation is recommended on server-side
            'items.*.line_total'     => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // -----------------------------------------------------
            // 2) Calculate totals (Using the submitted line totals)
            // -----------------------------------------------------

            $subtotal = collect($request->items)->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            // Adjustments from the form
            $discount   = $request->discount_amount_header ?? 0; // Assuming this field name from your previous code
            $tax        = $request->tax_amount_header ?? 0;      // Assuming this field name from your previous code
            $shipping   = $request->shipping_cost ?? 0;
            $paidAmount = $request->paid_amount;

            $total_cost = $subtotal - $discount + $tax + $shipping;
            $due_amount = $total_cost - $paidAmount;


            // -----------------------------------------------------
            // 3) Create Sale (Header)
            // -----------------------------------------------------

            $sale = Sale::create([
                'customer_id'       => $request->customer_id,
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'paid_amount'       => $paidAmount,
                'sell_date'         => now(),
                'description'       => $request->description,
                'subtotal_amount'   => $subtotal,
                'discount_amount'   => $discount,
                'tax_amount'        => $tax,
                'shipping_cost'     => $shipping,
                'total_cost'        => $total_cost,
                'due_amount'        => $due_amount,
            ]);


            // -----------------------------------------------------
            // 4) Insert Sales Items & Update Stock
            // -----------------------------------------------------

            foreach ($request->items as $item) {

                // Here you should calculate item-level discount/tax if applicable
                $itemDiscountAmount = 0; // Calculate based on $item['discount_id'] or percentage
                $itemTaxAmount      = 0;

                // Line total calculation should be server-side for safety
                $calculated_line_total = ($item['quantity'] * $item['unit_price']) - $itemDiscountAmount + $itemTaxAmount;

                SalesItem::create([
                    'sale_id'           => $sale->id,
                    'product_id'        => $item['product_id'],
                    'productunit_id'    => $item['productunit_id'],
                    'quantity'          => $item['quantity'],
                    'unit_price'        => $item['unit_price'],

                    'line_total'        => $calculated_line_total, // Use calculated value

                    'discount_id'       => $item['discount_id'] ?? null,
                    'discount_amount'   => $itemDiscountAmount,
                    'tax_amount'        => $itemTaxAmount,

                    'batch_no'          => $item['batch_no'] ?? null,
                    'expiry_date'       => $item['expiry_date'] ?? null,
                    'status'            => 'active',
                ]);

                // Reduce stock
                DB::table('stocks')
                    ->where('product_id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()
                ->route('salesitems.index')
                ->with('success', 'Sale created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Sale creation failed: ' . $e->getMessage());
        }
    }

    /**
     * List all sales items
     */
    public function index()
    {
        $items = SalesItem::with(['sale', 'product', 'unit'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('pages.salesitems.index', compact('items'));
    }
}
