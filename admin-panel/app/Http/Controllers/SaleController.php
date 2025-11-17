<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // Show all sales
    public function index()
    {
        $sales = Sale::with(['customer', 'items.product', 'paymentMethod'])
                     ->orderBy('id', 'desc')
                     ->paginate(15);

        return view('pages.sales.index', compact('sales'));
    }

    // Show create form
    public function create()
    {
        return view('pages.sales.create', [
            'customers'      => Customer::all(),
            'products'       => Product::all(),
            'productUnits'   => ProductUnit::all(),
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    // Store sale + items
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            // NOTE: 'productunit_id' is in the request but not the sale table or fillable, might be a bug. Assuming you meant for this to be removed or used differently.
            // For now, I'll keep the validation but omit the column from the Sale::create() call
            'productunit_id'     => 'nullable|exists:product_units,id',
            'payment_method_id'  => 'required|exists:payment_methods,id',
            'payment_status'     => 'required|string',
            'paid_amount'        => 'required|numeric',
            'items'              => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            // Add validation for optional fields from your schema if they are sent
            'discount_amount'    => 'nullable|numeric|min:0',
            'tax_amount'         => 'nullable|numeric|min:0',
            'shipping_cost'      => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $itemsData = $request->items;
            $subtotal = collect($itemsData)->sum(fn($item) => $item['quantity'] * $item['unit_price']);

            // Get optional amounts, defaulting to 0
            $discount = $request->input('discount_amount', 0);
            $tax = $request->input('tax_amount', 0);
            $shipping = $request->input('shipping_cost', 0);
            $paidAmount = $request->paid_amount;

            // Calculate totals
            $totalCost = $subtotal - $discount + $tax + $shipping;
            $dueAmount = $totalCost - $paidAmount;

            // Create sale
            $sale = Sale::create([
                'customer_id'       => $request->customer_id,
                // 'productunit_id'  => $request->productunit_id, // Excluded: Not in Sale Model fillable/Migration
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'paid_amount'       => $paidAmount,
                'subtotal_amount'   => $subtotal,
                'discount_amount'   => $discount,
                'tax_amount'        => $tax,
                'shipping_cost'     => $shipping,
                'total_cost'        => $totalCost,
                'due_amount'        => $dueAmount,
                'sell_date'         => now(),
            ]);

            // Create each item
            foreach ($itemsData as $item) {
                SalesItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Edit sale
    public function edit(Sale $sale)
    {
        return view('pages.sales.edit', [
            'sale'           => $sale->load('items'),
            'customers'      => Customer::all(),
            'products'       => Product::all(),
            'productUnits'   => ProductUnit::all(),
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    // Update sale + items
   public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            // NOTE: 'productunit_id' is in the request but not the sale table or fillable, might be a bug.
            'productunit_id'     => 'nullable|exists:product_units,id',
            'payment_method_id'  => 'required|exists:payment_methods,id',
            'payment_status'     => 'required|string',
            'paid_amount'        => 'required|numeric',
            'items'              => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            // Add validation for optional fields from your schema if they are sent
            'discount_amount'    => 'nullable|numeric|min:0',
            'tax_amount'         => 'nullable|numeric|min:0',
            'shipping_cost'      => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $itemsData = $request->items;
            $subtotal = collect($itemsData)->sum(fn($item) => $item['quantity'] * $item['unit_price']);

            // Get optional amounts, defaulting to 0
            $discount = $request->input('discount_amount', 0);
            $tax = $request->input('tax_amount', 0);
            $shipping = $request->input('shipping_cost', 0);
            $paidAmount = $request->paid_amount;

            // Calculate totals
            $totalCost = $subtotal - $discount + $tax + $shipping;
            $dueAmount = $totalCost - $paidAmount;

            // update sale
            $sale->update([
                'customer_id'       => $request->customer_id,
                // 'productunit_id'  => $request->productunit_id, // Excluded: Not in Sale Model fillable/Migration
                'payment_method_id' => $request->payment_method_id,
                'payment_status'    => $request->payment_status,
                'paid_amount'       => $paidAmount,
                'subtotal_amount'   => $subtotal,
                'discount_amount'   => $discount,
                'tax_amount'        => $tax,
                'shipping_cost'     => $shipping,
                'total_cost'        => $totalCost,
                'due_amount'        => $dueAmount,
            ]);

            // delete old items
            $sale->items()->delete();

            // Insert new items
            foreach ($itemsData as $item) {
                SalesItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Delete sale + items
    public function destroy(Sale $sale)
    {
        $sale->items()->delete();
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
