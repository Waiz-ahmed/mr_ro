<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use App\Models\UomCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UomsImport;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::with('category')->latest()->paginate(20);
        return view('foundation.uoms.index', compact('uoms'));
    }

    public function create()
    {
        $categories = UomCategory::where('status', 'active')->get();
        return view('foundation.uoms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:uom_categories,id',
            'name'        => 'required|string|max:100|unique:uom,name',
            'ratio'       => 'required|numeric|min:0',
            'is_base'     => 'boolean',
            'rounding'    => 'nullable|numeric|min:0',
            'status'      => 'in:active,inactive',
        ]);

        Uom::create($validated);

        return redirect()->route('uoms.index')->with('success', 'UOM created.');
    }

    public function show(Uom $uom)
    {
        $uom->load('category');
        return view('foundation.uoms.show', compact('uom'));
    }

    public function edit(Uom $uom)
    {
        $categories = UomCategory::where('status', 'active')->get();
        return view('foundation.uoms.edit', compact('uom', 'categories'));
    }

    public function update(Request $request, Uom $uom)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:uom_categories,id',
            'name'        => 'required|string|max:100|unique:uom,name,' . $uom->id,
            'ratio'       => 'required|numeric|min:0',
            'is_base'     => 'boolean',
            'rounding'    => 'nullable|numeric|min:0',
            'status'      => 'in:active,inactive',
        ]);

        $uom->update($validated);

        return redirect()->route('uoms.index')->with('success', 'UOM updated.');
    }

    public function destroy(Uom $uom)
    {
        $uom->delete();
        return redirect()->route('uoms.index')->with('success', 'UOM deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new UomsImport, $request->file('file'));
        return redirect()->back()->with('success', 'UOMs imported successfully!');
    }
}