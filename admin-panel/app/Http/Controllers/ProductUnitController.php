<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    // Display all product units
    public function index()
    {
        $units = ProductUnit::all();
        return view('pages.product_units.index', compact('units'));
    }

    // Show create form
    public function create()
    {
        return view('pages.product_units.create');
    }

    // Store new product unit
    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        ProductUnit::create($request->only(['unit_name', 'description']));

        return redirect()->route('productUnitIndex')->with('message', 'Unit added successfully!');
    }

    // Show edit form
    public function edit(ProductUnit $unit)
    {
        return view('pages.product_units.edit', compact('unit'));
    }

    // Update product unit
    public function update(Request $request, ProductUnit $unit)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $unit->update($request->only(['unit_name', 'description']));

        return redirect()->route('productUnitIndex')->with('message', 'Unit updated successfully!');
    }

    // Delete product unit
    public function destroy(ProductUnit $unit)
    {
        $unit->delete();
        return redirect()->route('productUnitIndex')->with('message', 'Unit deleted successfully!');
    }
}
