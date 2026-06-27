<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use App\Models\Shop;
use App\Models\Currency;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PricelistsImport;

class PricelistController extends Controller
{
    public function index()
    {
        $pricelists = Pricelist::with('shop', 'currency')->latest()->paginate(20);
        return view('products.pricelists.index', compact('pricelists'));
    }

    public function create()
    {
        $shops = Shop::where('status', 'active')->get();
        $currencies = Currency::where('status', 'active')->get();
        return view('products.pricelists.create', compact('shops', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_id'     => 'nullable|exists:shops,id',
            'currency_id' => 'required|exists:currencies,id',
            'name'        => 'required|string|max:191|unique:pricelists,name',
            'is_default'  => 'boolean',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'in:active,inactive',
        ]);
        Pricelist::create($validated);
        return redirect()->route('pricelists.index')->with('success', 'Pricelist created.');
    }

    public function show(Pricelist $pricelist)
    {
        $pricelist->load('items.product', 'items.category', 'currency');
        return view('products.pricelists.show', compact('pricelist'));
    }

    public function edit(Pricelist $pricelist)
    {
        $shops = Shop::where('status', 'active')->get();
        $currencies = Currency::where('status', 'active')->get();
        return view('products.pricelists.edit', compact('pricelist', 'shops', 'currencies'));
    }

    public function update(Request $request, Pricelist $pricelist)
    {
        $validated = $request->validate([
            'shop_id'     => 'nullable|exists:shops,id',
            'currency_id' => 'required|exists:currencies,id',
            'name'        => 'required|string|max:191|unique:pricelists,name,' . $pricelist->id,
            'is_default'  => 'boolean',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'in:active,inactive',
        ]);
        $pricelist->update($validated);
        return redirect()->route('pricelists.index')->with('success', 'Pricelist updated.');
    }

    public function destroy(Pricelist $pricelist)
    {
        $pricelist->delete();
        return redirect()->route('pricelists.index')->with('success', 'Pricelist deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new PricelistsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Pricelists imported.');
    }
}