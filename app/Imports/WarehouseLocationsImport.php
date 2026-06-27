<?php

namespace App\Imports;

use App\Models\WarehouseLocation;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WarehouseLocationsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $warehouse = Warehouse::where('name', $row['warehouse_name'])->first();
        if (!$warehouse) {
            throw new \Exception("Warehouse '{$row['warehouse_name']}' not found");
        }

        $parent = null;
        if (!empty($row['parent_name'])) {
            $parent = WarehouseLocation::where('name', $row['parent_name'])
                        ->where('warehouse_id', $warehouse->id)
                        ->first();
            if (!$parent) {
                throw new \Exception("Parent location '{$row['parent_name']}' not found in warehouse '{$warehouse->name}'");
            }
        }

        return new WarehouseLocation([
            'warehouse_id' => $warehouse->id,
            'parent_id'    => $parent ? $parent->id : null,
            'name'         => $row['name'],
            'full_path'    => $row['full_path'] ?? null,
            'type'         => $row['type'] ?? 'internal',
            'status'       => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'warehouse_name' => 'required|string',
            'name'           => 'required|string',
            'type'           => 'nullable|in:internal,input,output,virtual',
        ];
    }
}