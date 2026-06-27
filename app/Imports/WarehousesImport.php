<?php

namespace App\Imports;

use App\Models\Warehouse;
use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WarehousesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $shop = Shop::where('name', $row['shop_name'])->first();
        if (!$shop) {
            throw new \Exception("Shop '{$row['shop_name']}' not found");
        }

        return new Warehouse([
            'shop_id'     => $shop->id,
            'name'        => $row['name'],
            'short_name'  => $row['short_name'] ?? null,
            'address'     => $row['address'] ?? null,
            'is_default'  => $row['is_default'] ?? 0,
            'status'      => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'shop_name' => 'required|string',
            'name'      => 'required|string',
        ];
    }
}