<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('templates')
            ->with('parent')
            ->where('status', 'active')
            ->orderBy('name')
            ->paginate(20);

        return view('product_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:191',
            'parent_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
        ]);

        ProductCategory::create([
            'name'        => $request->name,
            'parent_id'   => $request->parent_id ?: null,
            'description' => $request->description,
            'status'      => 'active',
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name'      => 'required|string|max:191',
            'parent_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'parent_id'   => $request->parent_id ?: null,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy(ProductCategory $category)
    {
        if ($category->templates()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with products assigned to it.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}