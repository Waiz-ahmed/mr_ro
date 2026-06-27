<?php

namespace App\Http\Controllers;

use App\Models\ProductTemplate;
use App\Models\ProductCategory;
use App\Models\Uom;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductTemplatesImport;

class ProductTemplateController extends Controller
{
    public function index()
    {
        $templates = ProductTemplate::with('category', 'uom')->latest()->paginate(20);
        return view('products.templates.index', compact('templates'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->get();
        $uoms = Uom::where('status', 'active')->get();
        return view('products.templates.create', compact('categories', 'uoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'         => 'nullable|exists:product_categories,id',
            'uom_id'              => 'required|exists:uom,id',
            'uom_purchase_id'     => 'nullable|exists:uom,id',
            'name'                => 'required|string|max:255|unique:product_templates,name',
            'internal_ref'        => 'nullable|string|max:100',
            'barcode'             => 'nullable|string|max:100',
            'type'                => 'required|in:storable,consumable,service',
            'sale_price'          => 'nullable|numeric|min:0',
            'cost_price'          => 'nullable|numeric|min:0',
            'sale_ok'             => 'boolean',
            'purchase_ok'         => 'boolean',
            'has_variants'        => 'boolean',
            'track_inventory'     => 'boolean',
            'status'              => 'in:active,archived',
        ]);
        ProductTemplate::create($validated);
        return redirect()->route('product_templates.index')->with('success', 'Product template created.');
    }

    public function show(ProductTemplate $productTemplate)
    {
        $productTemplate->load('variants', 'category', 'uom');
        return view('products.templates.show', compact('productTemplate'));
    }

    public function edit(ProductTemplate $productTemplate)
    {
        $categories = ProductCategory::where('status', 'active')->get();
        $uoms = Uom::where('status', 'active')->get();
        return view('products.templates.edit', compact('productTemplate', 'categories', 'uoms'));
    }

    public function update(Request $request, ProductTemplate $productTemplate)
    {
        $validated = $request->validate([
            'category_id'         => 'nullable|exists:product_categories,id',
            'uom_id'              => 'required|exists:uom,id',
            'uom_purchase_id'     => 'nullable|exists:uom,id',
            'name'                => 'required|string|max:255|unique:product_templates,name,' . $productTemplate->id,
            'internal_ref'        => 'nullable|string|max:100',
            'barcode'             => 'nullable|string|max:100',
            'type'                => 'required|in:storable,consumable,service',
            'sale_price'          => 'nullable|numeric|min:0',
            'cost_price'          => 'nullable|numeric|min:0',
            'sale_ok'             => 'boolean',
            'purchase_ok'         => 'boolean',
            'has_variants'        => 'boolean',
            'track_inventory'     => 'boolean',
            'status'              => 'in:active,archived',
        ]);
        $productTemplate->update($validated);
        return redirect()->route('product_templates.index')->with('success', 'Template updated.');
    }

    public function destroy(ProductTemplate $productTemplate)
    {
        $productTemplate->delete();
        return redirect()->route('product_templates.index')->with('success', 'Template deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductTemplatesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Templates imported.');
    }
}