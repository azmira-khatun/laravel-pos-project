<?php
namespace App\Http\Controllers;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
public function index()
{
$sales = Sale::orderBy('id', 'desc')->paginate(15);
return view('sales.index', compact('sales'));
}


public function create()
{
return view('sales.create', [
'customers' => \App\Models\Customer::all(),
'products' => \App\Models\Product::all(),
'units' => \App\Models\ProductUnit::all(),
'paymentMethods' => \App\Models\PaymentMethod::all(),
]);
}

public function store(Request $request)
{
    // ------------------ VALIDATION ------------------
    $validated = $request->validate([
        'customer_id'        => 'required|exists:customers,id',
        'payment_method_id'  => 'required|exists:payment_methods,id',

        // sale summary fields
        'subtotal_amount'    => 'required|numeric|min:0',
        'discount_amount'    => 'nullable|numeric|min:0',
        'tax_amount'         => 'nullable|numeric|min:0',
        'shipping_cost'      => 'nullable|numeric|min:0',
        'total_cost'         => 'required|numeric|min:0',
        'paid_amount'        => 'required|numeric|min:0',
        'due_amount'         => 'required|numeric|min:0',
        'payment_status'     => 'required|string',

        // arrays
        'product_id'         => 'required|array',
        'product_id.*'       => 'required|exists:products,id',

        'productunit_id'     => 'required|array',
        'productunit_id.*'   => 'required|exists:product_units,id',

        'quantity'           => 'required|array',
        'quantity.*'         => 'required|integer|min:1',

        'unit_price'         => 'required|array',
        'unit_price.*'       => 'required|numeric|min:0',

        'discount_amount_item'   => 'nullable|array',
        'discount_amount_item.*' => 'nullable|numeric|min:0',

        'line_total'         => 'required|array',
        'line_total.*'       => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        // ------------------ CREATE SALE MASTER ------------------
        $sale = Sale::create([
            'customer_id'        => $request->customer_id,
            'payment_method_id'  => $request->payment_method_id,
            'subtotal_amount'    => $request->subtotal_amount,
            'discount_amount'    => $request->discount_amount ?? 0,
            'tax_amount'         => $request->tax_amount ?? 0,
            'shipping_cost'      => $request->shipping_cost ?? 0,
            'total_cost'         => $request->total_cost,
            'paid_amount'        => $request->paid_amount,
            'due_amount'         => $request->due_amount,
            'payment_status'     => $request->payment_status,
            'sell_date'          => now(),
        ]);


        // ------------------ LOOP FOR MULTIPLE ITEMS ------------------
        foreach ($request->product_id as $i => $productId) {

            // ------------ STOCK CHECK ------------
            $stock = Stock::where('product_id', $productId)->first();

            if (!$stock || $stock->quantity < $request->quantity[$i]) {
                DB::rollBack();

                return back()->with('error', "Not enough stock for Product ID: $productId");
            }

            // ------------ CREATE SALES ITEM ------------
            SalesItem::create([
                'sale_id'           => $sale->id,
                'product_id'        => $productId,
                'productunit_id'    => $request->productunit_id[$i],
                'quantity'          => $request->quantity[$i],
                'unit_price'        => $request->unit_price[$i],
                'discount_amount'   => $request->discount_amount_item[$i] ?? 0,
                'line_total'        => $request->line_total[$i],
            ]);

            // ------------ STOCK MINUS ------------
            $stock->decrement('quantity', $request->quantity[$i]);
        }

        DB::commit();

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
}
