<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTemplate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('template')->latest()->paginate(20);
        return view('products.variants.index', compact('products'));
    }

    public function create()
    {
        $templates = ProductTemplate::where('has_variants', true)->where('status', 'active')->get();
        return view('products.variants.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:product_templates,id',
            'sku'         => 'nullable|string|max:100|unique:products,sku',
            'barcode'     => 'nullable|string|max:100|unique:products,barcode',
            'weight'      => 'nullable|numeric|min:0',
            'volume'      => 'nullable|numeric|min:0',
            'image'       => 'nullable|string|max:500',
            'extra_price' => 'nullable|numeric|min:0',
            'status'      => 'in:active,archived',
        ]);
        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Variant created.');
    }

    public function show(Product $product)
    {
        $product->load('template');
        return view('products.variants.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $templates = ProductTemplate::where('has_variants', true)->where('status', 'active')->get();
        return view('products.variants.edit', compact('product', 'templates'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:product_templates,id',
            'sku'         => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'barcode'     => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'weight'      => 'nullable|numeric|min:0',
            'volume'      => 'nullable|numeric|min:0',
            'image'       => 'nullable|string|max:500',
            'extra_price' => 'nullable|numeric|min:0',
            'status'      => 'in:active,archived',
        ]);
        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Variant updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Variant deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Variants imported.');
    }
}