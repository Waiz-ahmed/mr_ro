<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductAttributeValuesImport;

class ProductAttributeValueController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductAttributeValue::with('attribute');
        if ($request->attribute_id) {
            $query->where('attribute_id', $request->attribute_id);
        }
        $values = $query->latest()->paginate(20);
        $attributes = ProductAttribute::where('status', 'active')->get();
        return view('products.attribute_values.index', compact('values', 'attributes'));
    }

    public function create()
    {
        $attributes = ProductAttribute::where('status', 'active')->get();
        return view('products.attribute_values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:product_attributes,id',
            'value'        => 'required|string|max:191|unique:product_attribute_values,value,NULL,id,attribute_id,' . $request->attribute_id,
            'status'       => 'in:active,inactive',
        ]);
        ProductAttributeValue::create($validated);
        return redirect()->route('product_attribute_values.index')->with('success', 'Attribute value created.');
    }

    public function show(ProductAttributeValue $productAttributeValue)
    {
        $productAttributeValue->load('attribute');
        return view('products.attribute_values.show', compact('productAttributeValue'));
    }

    public function edit(ProductAttributeValue $productAttributeValue)
    {
        $attributes = ProductAttribute::where('status', 'active')->get();
        return view('products.attribute_values.edit', compact('productAttributeValue', 'attributes'));
    }

    public function update(Request $request, ProductAttributeValue $productAttributeValue)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:product_attributes,id',
            'value'        => 'required|string|max:191|unique:product_attribute_values,value,' . $productAttributeValue->id . ',id,attribute_id,' . $request->attribute_id,
            'status'       => 'in:active,inactive',
        ]);
        $productAttributeValue->update($validated);
        return redirect()->route('product_attribute_values.index')->with('success', 'Value updated.');
    }

    public function destroy(ProductAttributeValue $productAttributeValue)
    {
        $productAttributeValue->delete();
        return redirect()->route('product_attribute_values.index')->with('success', 'Value deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductAttributeValuesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Values imported.');
    }
}