<?php

namespace App\Http\Controllers;

use App\Models\UomCategory;
use App\Models\Uom;
use Illuminate\Http\Request;

class UomCategoryController extends Controller
{
    public function index()
    {
        $categories = UomCategory::withCount('uoms')
            ->where('status', 'active')
            ->orderBy('name')
            ->paginate(20);
        return view('uom_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:uom_categories,name',
        ]);

        UomCategory::create(['name' => $request->name, 'status' => 'active']);
        return redirect()->back()->with('success', 'UOM Category created successfully!');
    }

    public function update(Request $request, UomCategory $uomCategory)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:uom_categories,name,' . $uomCategory->id,
        ]);

        $uomCategory->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'UOM Category updated successfully!');
    }

    public function destroy(UomCategory $uomCategory)
    {
        if ($uomCategory->uoms()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete a category that has UOMs assigned to it.');
        }
        $uomCategory->delete();
        return redirect()->back()->with('success', 'UOM Category deleted successfully!');
    }
}