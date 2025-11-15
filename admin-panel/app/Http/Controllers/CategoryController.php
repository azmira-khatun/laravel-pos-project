<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * Route: /add-category
     * Name: category.index
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        // আপনার ব্লেড ফাইলটি 'pages.categories.index' এ আছে
        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * Route: /category/create
     * Name: category.create
     */
    public function create()
    {
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * Route: POST /category/store
     * Name: category.store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:categories,name',
        ]);

        Category::create($validated);

        // আপনার index রুটের নাম 'category.index'
        return redirect()->route('category.index')
                         ->with('message', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     * (এই মেথডটি আপনার রুটে নেই, তবে ভালো প্র্যাকটিসের জন্য রাখা হলো)
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * Route: GET /category/edit/{id}
     * Name: category.edit
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * Route: POST /category/update/{id}
     * Name: category.update
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('category.index')
                         ->with('message', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * Route: DELETE /category/delete/{id}
     * Name: category.delete
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();
            return redirect()->route('category.index')
                             ->with('message', 'Category deleted successfully.');
        } catch (\Exception $e) {
            // যদি ক্যাটেগরিটি অন্য কিছুর সাথে যুক্ত থাকে (যেমন সাব-ক্যাটেগরি)
            return redirect()->route('category.index')
                             ->with('error', 'Cannot delete category: It is linked to other records.');
        }
    }
}
