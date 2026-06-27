<?php

namespace App\Http\Controllers;

use App\Models\UomCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UomCategoriesImport;

class UomCategoryController extends Controller
{
    public function index()
    {
        $categories = UomCategory::latest()->paginate(20);
        return view('foundation.uom_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('foundation.uom_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:uom_categories,name',
            'status' => 'in:active,inactive',
        ]);

        UomCategory::create($validated);

        return redirect()->route('uom_categories.index')->with('success', 'UOM Category created.');
    }

    public function show(UomCategory $uomCategory)
    {
        return view('foundation.uom_categories.show', compact('uomCategory'));
    }

    public function edit(UomCategory $uomCategory)
    {
        return view('foundation.uom_categories.edit', compact('uomCategory'));
    }

    public function update(Request $request, UomCategory $uomCategory)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:uom_categories,name,' . $uomCategory->id,
            'status' => 'in:active,inactive',
        ]);

        $uomCategory->update($validated);

        return redirect()->route('uom_categories.index')->with('success', 'UOM Category updated.');
    }

    public function destroy(UomCategory $uomCategory)
    {
        $uomCategory->delete();
        return redirect()->route('uom_categories.index')->with('success', 'UOM Category deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new UomCategoriesImport, $request->file('file'));
        return redirect()->back()->with('success', 'UOM Categories imported successfully!');
    }
}