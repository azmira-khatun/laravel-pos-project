<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use App\Models\Sale;
use App\Models\Product;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PaymentMethod;
class SalesItemController extends Controller
{
    /**
     * Display a listing of the sales items.
     */
    public function index()
    {
        $items = SalesItem::with(['sale', 'product', 'unit'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('pages.salesitems.index', compact('items'));
    }

    /**
     * Show the form for creating a new sales item (single).
     */

public function create()
{
    // Fetch all customers, products, and payment methods
    $customers = Customer::all();
    $products = Product::all();
    $paymentMethods = PaymentMethod::all();

    // Pass them to the view
    return view('pages.salesitems.create', compact('customers', 'products', 'paymentMethods'));
}

    /**
     * Store a single new sales item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_id'        => 'required',
            'product_id'     => 'required',
            'productunit_id' => 'required',
            'quantity'       => 'required|numeric|min:1',
            'unit_price'     => 'required|numeric|min:0',
            'discount_amount'=> 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $lineTotal = ($request->quantity * $request->unit_price) - $request->discount_amount;

            // Insert single sales item
            $item = SalesItem::create([
                'sale_id'        => $request->sale_id,
                'product_id'     => $request->product_id,
                'productunit_id' => $request->productunit_id,
                'quantity'       => $request->quantity,
                'unit_price'     => $request->unit_price,
                'discount_amount'=> $request->discount_amount ?? 0,
                'line_total'     => $lineTotal,
            ]);

            // Update sale total
            $this->updateSaleTotal($request->sale_id);

            // Decrease stock
            DB::table('stocks')
                ->where('product_id', $request->product_id)
                ->decrement('quantity', $request->quantity);

            DB::commit();

            return redirect()->route('salesitems.index')
                ->with('success', 'Sales Item Added Successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified sales item.
     */
    public function edit($id)
    {
        return view('salesitems.edit', [
            'item'     => SalesItem::findOrFail($id),
            'sales'    => Sale::all(),
            'products' => Product::all(),
            'units'    => ProductUnit::all(),
        ]);
    }

    /**
     * Update the specified sales item.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id'     => 'required',
            'productunit_id' => 'required',
            'quantity'       => 'required|numeric|min:1',
            'unit_price'     => 'required|numeric|min:0',
            'discount_amount'=> 'nullable|numeric|min:0',
        ]);

        $item = SalesItem::findOrFail($id);

        DB::beginTransaction();

        try {
            // restore previous stock
            DB::table('stocks')
                ->where('product_id', $item->product_id)
                ->increment('quantity', $item->quantity);

            $lineTotal = ($request->quantity * $request->unit_price) - $request->discount_amount;

            $item->update([
                'product_id'     => $request->product_id,
                'productunit_id' => $request->productunit_id,
                'quantity'       => $request->quantity,
                'unit_price'     => $request->unit_price,
                'discount_amount'=> $request->discount_amount ?? 0,
                'line_total'     => $lineTotal,
            ]);

            // update new stock
            DB::table('stocks')
                ->where('product_id', $request->product_id)
                ->decrement('quantity', $request->quantity);

            // Update sale total
            $this->updateSaleTotal($item->sale_id);

            DB::commit();

            return redirect()->route('salesitems.index')
                ->with('success', 'Sales Item Updated Successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified sales item.
     */
    public function destroy($id)
    {
        $item = SalesItem::findOrFail($id);

        DB::beginTransaction();

        try {
            // restore stock
            DB::table('stocks')
                ->where('product_id', $item->product_id)
                ->increment('quantity', $item->quantity);

            $sale_id = $item->sale_id;
            $item->delete();

            // update sale total
            $this->updateSaleTotal($sale_id);

            DB::commit();

            return redirect()->route('salesitems.index')
                ->with('success', 'Sales Item Deleted Successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Helper: Update total amount in sale parent table.
     */
    private function updateSaleTotal($sale_id)
    {
        $total = SalesItem::where('sale_id', $sale_id)->sum('line_total');

        Sale::where('id', $sale_id)->update([
            'total_amount' => $total
        ]);
    }
}
