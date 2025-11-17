<?php

namespace App\Http\Controllers;

use App\Models\ProfitRecord;
use App\Models\SalesItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProfitRecordController extends Controller
{
    public function index()
    {
        $records = ProfitRecord::with(['saleItem', 'product'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('profit_records.index', compact('records'));
    }

    public function create()
    {
        return view('profit_records.create', [
            'saleItems' => SalesItem::all(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_item_id' => 'required|exists:sales_items,id|unique:profit_records,sale_item_id',
            'product_id' => 'required|exists:products,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'profit_amount' => 'required|numeric',
            'record_date' => 'nullable|date',
        ]);

        ProfitRecord::create([
            'sale_item_id' => $request->sale_item_id,
            'product_id' => $request->product_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'profit_amount' => $request->profit_amount,
            'record_date' => $request->record_date ?? now()->format('Y-m-d'),
        ]);

        return redirect()->route('profitRecords.index')->with('success', 'Profit record created successfully.');
    }

    public function show(ProfitRecord $profitRecord)
    {
        return view('profit_records.show', compact('profitRecord'));
    }

    public function edit(ProfitRecord $profitRecord)
    {
        return view('profit_records.edit', [
            'profitRecord' => $profitRecord,
            'saleItems' => SalesItem::all(),
            'products' => Product::all(),
        ]);
    }

    public function update(Request $request, ProfitRecord $profitRecord)
    {
        $request->validate([
            'sale_item_id' => 'required|exists:sales_items,id|unique:profit_records,sale_item_id,' . $profitRecord->id,
            'product_id' => 'required|exists:products,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'profit_amount' => 'required|numeric',
            'record_date' => 'nullable|date',
        ]);

        $profitRecord->update([
            'sale_item_id' => $request->sale_item_id,
            'product_id' => $request->product_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
            'profit_amount' => $request->profit_amount,
            'record_date' => $request->record_date ?? now()->format('Y-m-d'),
        ]);

        return redirect()->route('profitRecords.index')->with('success', 'Profit record updated successfully.');
    }

    public function destroy(ProfitRecord $profitRecord)
    {
        $profitRecord->delete();
        return redirect()->route('profitRecords.index')->with('success', 'Profit record deleted successfully.');
    }
}
