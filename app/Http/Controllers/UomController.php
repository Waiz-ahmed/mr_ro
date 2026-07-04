<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use App\Models\UomCategory;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index()
    {
        $uoms       = Uom::with('category')->where('status', 'active')->orderBy('name')->paginate(20);
        $categories = UomCategory::where('status', 'active')->orderBy('name')->get();
        return view('uoms.index', compact('uoms', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:uom_categories,id',
            'name'        => 'required|string|max:100|unique:uom,name',
            'ratio'       => 'required|numeric|min:0',
            'is_base'     => 'nullable|boolean',
            'rounding'    => 'nullable|numeric|min:0',
        ]);

        Uom::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'ratio'       => $request->ratio,
            'is_base'     => $request->has('is_base') ? 1 : 0,
            'rounding'    => $request->rounding ?? 0.01,
            'status'      => 'active',
        ]);

        return redirect()->back()->with('success', 'Unit of Measure created successfully!');
    }

    public function update(Request $request, Uom $uom)
    {
        $request->validate([
            'category_id' => 'required|exists:uom_categories,id',
            'name'        => 'required|string|max:100|unique:uom,name,' . $uom->id,
            'ratio'       => 'required|numeric|min:0',
            'is_base'     => 'nullable|boolean',
            'rounding'    => 'nullable|numeric|min:0',
        ]);

        $uom->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'ratio'       => $request->ratio,
            'is_base'     => $request->has('is_base') ? 1 : 0,
            'rounding'    => $request->rounding ?? 0.01,
        ]);

        return redirect()->back()->with('success', 'Unit of Measure updated successfully!');
    }

    public function destroy(Uom $uom)
    {
        $uom->delete();
        return redirect()->back()->with('success', 'Unit of Measure deleted successfully!');
    }
}