<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use Illuminate\Http\Request;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        $invoices = SalesInvoice::all();
        return response()->json($invoices);
    }

 public function show($id)
{
    // invoice + relation‑gulo eager load করা ভালো
    $invoice = SalesInvoice::with(['sale.items', 'customer', 'payments'])
        ->findOrFail($id);

    return view('sales_invoices.show', compact('invoice'));
}



    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number' => 'required|string|max:100|unique:sales_invoices,invoice_number',
            'sale_id' => 'required|integer|unique:sales_invoices,sale_id',
            'customer_id' => 'required|integer',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'due_amount' => 'numeric',
            'payment_status' => 'required|string|max:50',
        ]);

        $invoice = SalesInvoice::create($data);
        return response()->json($invoice, 201);
    }

    public function update(Request $request, $id)
    {
        $invoice = SalesInvoice::findOrFail($id);

        $data = $request->validate([
            'invoice_number' => 'string|max:100|unique:sales_invoices,invoice_number,' . $invoice->id,
            'sale_id' => 'integer|unique:sales_invoices,sale_id,' . $invoice->id,
            'customer_id' => 'integer',
            'invoice_date' => 'date',
            'total_amount' => 'numeric',
            'due_amount' => 'numeric',
            'payment_status' => 'string|max:50',
        ]);

        $invoice->update($data);
        return response()->json($invoice);
    }

    public function destroy($id)
    {
        $invoice = SalesInvoice::findOrFail($id);
        $invoice->delete();
        return response()->json(null, 204);
    }
}
