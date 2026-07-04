<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTemplate;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductTemplate::with(['category', 'products'])
            ->withCount('products')
            ->where('status', 'active');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name or internal ref
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('internal_ref', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $products   = $query->orderBy('name')->paginate(20)->withQueryString();
        $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:product_categories,id',
            'sale_price'  => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'type'        => 'required|in:storable,consumable,service',
            'internal_ref'=> 'nullable|string|max:100',
            'barcode'     => 'nullable|string|max:100',
            'uom_id'      => 'required|exists:uom,id',
        ]);

        // Auto-generate internal_ref if not provided
        $internalRef = $request->internal_ref;
        if (empty($internalRef)) {
            $last = ProductTemplate::where('internal_ref', 'like', 'MPR-%')
                ->orderByRaw('CAST(SUBSTRING(internal_ref, 5) AS UNSIGNED) DESC')
                ->value('internal_ref');

            $nextNumber = $last ? ((int) substr($last, 4)) + 1 : 1;
            $internalRef = 'MPR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        $template = ProductTemplate::create([
            'name'            => $request->name,
            'category_id'     => $request->category_id ?: null,
            'sale_price'      => $request->sale_price,
            'cost_price'      => $request->cost_price ?? 0,
            'type'            => $request->type,
            'internal_ref'    => $internalRef,
            'barcode'         => $request->barcode,
            'uom_id'          => $request->uom_id,
            'description'     => $request->description,
            'sale_ok'         => $request->has('sale_ok') ? 1 : 0,
            'purchase_ok'     => $request->has('purchase_ok') ? 1 : 0,
            'track_inventory' => $request->has('track_inventory') ? 1 : 0,
            'status'          => 'active',
        ]);

        Product::create([
            'template_id' => $template->id,
            'sku'         => $internalRef,
            'barcode'     => $request->barcode,
            'extra_price' => 0,
            'status'      => 'active',
        ]);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function update(Request $request, ProductTemplate $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:product_categories,id',
            'sale_price'  => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'type'        => 'required|in:storable,consumable,service',
        ]);

        $product->update([
            'name'        => $request->name,
            'category_id' => $request->category_id ?: null,
            'sale_price'  => $request->sale_price,
            'cost_price'  => $request->cost_price ?? 0,
            'type'        => $request->type,
            'internal_ref'=> $request->internal_ref,
            'barcode'     => $request->barcode,
            'description' => $request->description,
            'sale_ok'     => $request->has('sale_ok') ? 1 : 0,
            'purchase_ok' => $request->has('purchase_ok') ? 1 : 0,
            'track_inventory' => $request->has('track_inventory') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy(ProductTemplate $product)
    {
        $product->products()->delete();
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}