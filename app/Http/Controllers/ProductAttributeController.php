<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductAttributesImport;

class ProductAttributeController extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::with('values')->latest()->paginate(20);
        return view('products.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('products.attributes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:product_attributes,name',
            'status' => 'in:active,inactive',
        ]);
        ProductAttribute::create($validated);
        return redirect()->route('product_attributes.index')->with('success', 'Attribute created.');
    }

    public function show(ProductAttribute $productAttribute)
    {
        $productAttribute->load('values');
        return view('products.attributes.show', compact('productAttribute'));
    }

    public function edit(ProductAttribute $productAttribute)
    {
        return view('products.attributes.edit', compact('productAttribute'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100|unique:product_attributes,name,' . $productAttribute->id,
            'status' => 'in:active,inactive',
        ]);
        $productAttribute->update($validated);
        return redirect()->route('product_attributes.index')->with('success', 'Attribute updated.');
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();
        return redirect()->route('product_attributes.index')->with('success', 'Attribute deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductAttributesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Attributes imported.');
    }
}