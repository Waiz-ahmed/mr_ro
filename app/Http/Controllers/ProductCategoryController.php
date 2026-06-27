<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductCategoriesImport;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('parent')->latest()->paginate(20);
        return view('products.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->get();
        return view('products.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:product_categories,id',
            'name'      => 'required|string|max:191|unique:product_categories,name',
            'description'=> 'nullable|string',
            'status'    => 'in:active,inactive',
        ]);
        ProductCategory::create($validated);
        return redirect()->route('product_categories.index')->with('success', 'Category created.');
    }

    public function show(ProductCategory $productCategory)
    {
        $productCategory->load('parent', 'children');
        return view('products.categories.show', compact('productCategory'));
    }

    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::where('status', 'active')->where('id', '!=', $productCategory->id)->get();
        return view('products.categories.edit', compact('productCategory', 'categories'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:product_categories,id',
            'name'      => 'required|string|max:191|unique:product_categories,name,' . $productCategory->id,
            'description'=> 'nullable|string',
            'status'    => 'in:active,inactive',
        ]);
        $productCategory->update($validated);
        return redirect()->route('product_categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->route('product_categories.index')->with('success', 'Category deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductCategoriesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Categories imported.');
    }
}