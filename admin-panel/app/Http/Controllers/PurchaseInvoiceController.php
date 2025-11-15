<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    // List all invoices
    public function index()
    {
        $purchaseInvoices = PurchaseInvoice::orderBy('id', 'desc')->paginate(10);
        return view('pages.purchase_invoices.index', compact('purchaseInvoices'));
    }

    // Show form to create a new invoice
    public function create()
    {
        $purchases = Purchase::all(); // For selecting purchase
        return view('pages.purchase_invoices.create', compact('purchases'));
    }

    // Store a new invoice
    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_id' => 'required|integer|exists:purchases,id',
            'invoice_number' => 'required|unique:purchase_invoices,invoice_number',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'due_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:50',
        ]);

        PurchaseInvoice::create($data);

        return redirect()->route('purchaseInvoices.index')->with('success', 'Invoice created successfully.');
    }

    // Show a single invoice
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.show', compact('purchaseInvoice'));
    }

    // Optional: delete an invoice
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        $purchaseInvoice->delete();
        return redirect()->route('purchaseInvoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
