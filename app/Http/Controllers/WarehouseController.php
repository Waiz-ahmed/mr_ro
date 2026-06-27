<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Shop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WarehousesImport;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('shop')->latest()->paginate(20);
        return view('foundation.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $shops = Shop::where('status', 'active')->get();
        return view('foundation.warehouses.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_id'     => 'required|exists:shops,id',
            'name'        => 'required|string|max:191|unique:warehouses,name,NULL,id,shop_id,' . $request->shop_id,
            'short_name'  => 'nullable|string|max:10',
            'address'     => 'nullable|string',
            'is_default'  => 'boolean',
            'status'      => 'in:active,inactive',
        ]);

        Warehouse::create($validated);

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created.');
    }

    public function show(Warehouse $warehouse)
    {
        $warehouse->load('shop', 'locations');
        return view('foundation.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        $shops = Shop::where('status', 'active')->get();
        return view('foundation.warehouses.edit', compact('warehouse', 'shops'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'shop_id'     => 'required|exists:shops,id',
            'name'        => 'required|string|max:191|unique:warehouses,name,' . $warehouse->id . ',id,shop_id,' . $request->shop_id,
            'short_name'  => 'nullable|string|max:10',
            'address'     => 'nullable|string',
            'is_default'  => 'boolean',
            'status'      => 'in:active,inactive',
        ]);

        $warehouse->update($validated);

        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new WarehousesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Warehouses imported successfully!');
    }
}