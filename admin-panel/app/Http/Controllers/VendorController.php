<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::paginate(10);
        return view('pages.vendor.viewVendor', compact('vendors'));
    }

    public function create()
    {
        return view('pages.vendor.createVendor');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:vendors,name',
            'email' => 'nullable|email|max:100|unique:vendors,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tin_number' => 'nullable|string|max:50',
            'bank_details' => 'nullable|string',
        ]);

        Vendor::create($validatedData);

        return redirect()->route('vendorIndex')
                         ->with('message', 'Vendor added successfully!');
    }

    public function show(Vendor $vendor)
    {
        return view('pages.vendor.showVendor', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('pages.vendor.editVendor', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('vendors', 'name')->ignore($vendor->id),
            ],
            'email' => [
                'nullable',
                'email',
                'max:100',
                Rule::unique('vendors', 'email')->ignore($vendor->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tin_number' => 'nullable|string|max:50',
            'bank_details' => 'nullable|string',
        ]);

        $vendor->update($validatedData);

        return redirect()->route('vendorIndex')
                         ->with('message', 'Vendor updated successfully!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendorIndex')
                         ->with('message', 'Vendor deleted successfully!');
    }
}
