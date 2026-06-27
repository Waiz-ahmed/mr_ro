<?php

namespace App\Http\Controllers;

use App\Models\PricelistItem;
use App\Models\Pricelist;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PricelistItemsImport;

class PricelistItemController extends Controller
{
    public function index(Request $request)
    {
        $query = PricelistItem::with('pricelist', 'product', 'category');
        if ($request->pricelist_id) {
            $query->where('pricelist_id', $request->pricelist_id);
        }
        $items = $query->latest()->paginate(20);
        $pricelists = Pricelist::where('status', 'active')->get();
        return view('products.pricelist_items.index', compact('items', 'pricelists'));
    }

    public function create()
    {
        $pricelists = Pricelist::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        $categories = ProductCategory::where('status', 'active')->get();
        return view('products.pricelist_items.create', compact('pricelists', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pricelist_id'   => 'required|exists:pricelists,id',
            'product_id'     => 'nullable|exists:products,id',
            'category_id'    => 'nullable|exists:product_categories,id',
            'min_qty'        => 'nullable|numeric|min:0',
            'compute_method' => 'required|in:fixed,discount,formula',
            'price'          => 'nullable|numeric|min:0',
            'discount_pct'   => 'nullable|numeric|min:0|max:100',
            'price_formula'  => 'nullable|string|max:255',
            'date_start'     => 'nullable|date',
            'date_end'       => 'nullable|date|after_or_equal:date_start',
            'status'         => 'in:active,inactive',
        ]);
        PricelistItem::create($validated);
        return redirect()->route('pricelist_items.index')->with('success', 'Pricelist item created.');
    }

    public function show(PricelistItem $pricelistItem)
    {
        $pricelistItem->load('pricelist', 'product', 'category');
        return view('products.pricelist_items.show', compact('pricelistItem'));
    }

    public function edit(PricelistItem $pricelistItem)
    {
        $pricelists = Pricelist::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        $categories = ProductCategory::where('status', 'active')->get();
        return view('products.pricelist_items.edit', compact('pricelistItem', 'pricelists', 'products', 'categories'));
    }

    public function update(Request $request, PricelistItem $pricelistItem)
    {
        $validated = $request->validate([
            'pricelist_id'   => 'required|exists:pricelists,id',
            'product_id'     => 'nullable|exists:products,id',
            'category_id'    => 'nullable|exists:product_categories,id',
            'min_qty'        => 'nullable|numeric|min:0',
            'compute_method' => 'required|in:fixed,discount,formula',
            'price'          => 'nullable|numeric|min:0',
            'discount_pct'   => 'nullable|numeric|min:0|max:100',
            'price_formula'  => 'nullable|string|max:255',
            'date_start'     => 'nullable|date',
            'date_end'       => 'nullable|date|after_or_equal:date_start',
            'status'         => 'in:active,inactive',
        ]);
        $pricelistItem->update($validated);
        return redirect()->route('pricelist_items.index')->with('success', 'Item updated.');
    }

    public function destroy(PricelistItem $pricelistItem)
    {
        $pricelistItem->delete();
        return redirect()->route('pricelist_items.index')->with('success', 'Item deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new PricelistItemsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Items imported.');
    }
}