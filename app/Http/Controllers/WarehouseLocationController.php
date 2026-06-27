<?php

namespace App\Http\Controllers;

use App\Models\WarehouseLocation;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WarehouseLocationsImport;

class WarehouseLocationController extends Controller
{
    public function index(Request $request)
    {
        $query = WarehouseLocation::with('warehouse', 'parent');
        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }
        $locations = $query->latest()->paginate(20);
        $warehouses = Warehouse::where('status', 'active')->get();
        return view('foundation.warehouse_locations.index', compact('locations', 'warehouses'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('status', 'active')->get();
        $parents = WarehouseLocation::where('status', 'active')->get();
        return view('foundation.warehouse_locations.create', compact('warehouses', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'parent_id'    => 'nullable|exists:warehouse_locations,id',
            'name'         => 'required|string|max:191|unique:warehouse_locations,name,NULL,id,warehouse_id,' . $request->warehouse_id,
            'full_path'    => 'nullable|string|max:500',
            'type'         => 'required|in:internal,input,output,virtual',
            'status'       => 'in:active,inactive',
        ]);

        WarehouseLocation::create($validated);

        return redirect()->route('warehouse_locations.index')->with('success', 'Location created.');
    }

    public function show(WarehouseLocation $warehouseLocation)
    {
        $warehouseLocation->load('warehouse', 'parent', 'children');
        return view('foundation.warehouse_locations.show', compact('warehouseLocation'));
    }

    public function edit(WarehouseLocation $warehouseLocation)
    {
        $warehouses = Warehouse::where('status', 'active')->get();
        $parents = WarehouseLocation::where('warehouse_id', $warehouseLocation->warehouse_id)
                    ->where('id', '!=', $warehouseLocation->id)
                    ->where('status', 'active')
                    ->get();
        return view('foundation.warehouse_locations.edit', compact('warehouseLocation', 'warehouses', 'parents'));
    }

    public function update(Request $request, WarehouseLocation $warehouseLocation)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'parent_id'    => 'nullable|exists:warehouse_locations,id',
            'name'         => 'required|string|max:191|unique:warehouse_locations,name,' . $warehouseLocation->id . ',id,warehouse_id,' . $request->warehouse_id,
            'full_path'    => 'nullable|string|max:500',
            'type'         => 'required|in:internal,input,output,virtual',
            'status'       => 'in:active,inactive',
        ]);

        $warehouseLocation->update($validated);

        return redirect()->route('warehouse_locations.index')->with('success', 'Location updated.');
    }

    public function destroy(WarehouseLocation $warehouseLocation)
    {
        $warehouseLocation->delete();
        return redirect()->route('warehouse_locations.index')->with('success', 'Location deleted.');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new WarehouseLocationsImport, $request->file('file'));
        return redirect()->back()->with('success', 'Locations imported successfully!');
    }
}