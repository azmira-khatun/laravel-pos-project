<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // -----------------------------
    // SINGLE PRODUCT CRUD
    // -----------------------------

public function index()
{
    // === FIX: Fetch only the category with ID = 1, and its nested relationships ===
    $categories = Category::where('id', 1)
        ->with([
            'subCategories.products.productUnit' => function ($query) {
                // Eager load SubCategory and ProductUnit relationships for the products
                $query->with(['subCategory', 'productUnit']);
            }
        ])
        ->get();
    // =============================================================================

    return view('pages.products.index', compact('categories'));
}

    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $productUnits = ProductUnit::all();

        return view('pages.products.create', compact('categories', 'subCategories', 'productUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'productunit_id' => 'required|integer|exists:product_units,id',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'description' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'subCategory', 'productUnit']);
        return view('pages.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $productUnits = ProductUnit::all();

        return view('pages.products.edit', compact('product', 'categories', 'subCategories', 'productUnits'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'sub_category_id' => 'sometimes|required|integer|exists:sub_categories,id',
            'productunit_id' => 'sometimes|required|integer|exists:product_units,id',
            'barcode' => "nullable|string|max:100|unique:products,barcode,{$product->id}",
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // -----------------------------
    // MULTIPLE PRODUCT CREATE/STORE
    // -----------------------------

    public function createMultiple()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $productUnits = ProductUnit::all();

        return view('pages.products.create-multiple', compact('categories', 'subCategories', 'productUnits'));
    }

    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'products.*.name' => 'required|string|max:150',
            'products.*.category_id' => 'required|integer|exists:categories,id',
            'products.*.sub_category_id' => 'required|integer|exists:sub_categories,id',
            'products.*.productunit_id' => 'required|integer|exists:product_units,id',
            'products.*.barcode' => 'nullable|string|max:100|unique:products,barcode',
            'products.*.description' => 'nullable|string',
        ]);

        foreach ($request->products as $data) {
            Product::create($data);
        }

        return redirect()->route('products.index')->with('success', 'Multiple products added successfully!');
    }
}
