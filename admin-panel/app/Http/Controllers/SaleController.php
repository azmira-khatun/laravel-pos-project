<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\PaymentMethod;

class SaleController extends Controller
{
    // Show all sales
    public function index()
    {
        $sales = Sale::with(['customer', 'product', 'productUnit', 'paymentMethod'])
                     ->orderBy('id', 'desc')
                     ->paginate(15);
        return view('pages.sales.index', compact('sales'));
    }

    // Show form to create sale
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        $productUnits = ProductUnit::all();
        $paymentMethods = PaymentMethod::all();

        return view('pages.sales.create', compact('customers', 'products', 'productUnits', 'paymentMethods'));
    }

    // Store sale
   public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'product_id' => 'required|exists:products,id',
        'productunit_id' => 'required|exists:product_units,id',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'payment_status' => 'required|string',
        'paid_amount' => 'required|numeric',
    ]);

    // Add sell_date automatically
    $data = $request->all();
    $data['sell_date'] = now(); // current datetime

    Sale::create($data);

    return redirect()->route('sales.index')->with('success', 'Sale added successfully.');
}

    // Show form to edit
    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $products = Product::all();
        $productUnits = ProductUnit::all();
        $paymentMethods = PaymentMethod::all();

        return view('pages.sales.edit', compact('sale', 'customers', 'products', 'productUnits', 'paymentMethods'));
    }

    // Update sale
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'productunit_id' => 'required|exists:product_units,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_status' => 'required|string',
            'paid_amount' => 'required|numeric',
        ]);

        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    // Delete sale
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
