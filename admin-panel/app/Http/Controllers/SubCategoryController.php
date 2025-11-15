<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('pages.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::create($request->only(['name', 'category_id']));

        return redirect()->route('subCategory.index')
                         ->with('success', 'Sub-category created successfully.');
    }

    public function show(SubCategory $subCategory)
    {
        return view('pages.sub_categories.show', compact('subCategory'));
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('pages.sub_categories.edit', compact('subCategory','categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subCategory->update($request->only(['name','category_id']));

        return redirect()->route('subCategory.index')
                         ->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->route('subCategory.index')
                         ->with('success', 'Sub-category deleted successfully.');
    }
}
