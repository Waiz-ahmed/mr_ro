<?php

namespace App\Imports;

use App\Models\Pricelist;
use App\Models\Shop;
use App\Models\Currency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PricelistsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $shop = !empty($row['shop_name']) ? Shop::where('name', $row['shop_name'])->first() : null;
        $currency = Currency::where('code', $row['currency_code'])->first();
        if (!$currency) throw new \Exception("Currency '{$row['currency_code']}' not found");

        return new Pricelist([
            'shop_id'     => $shop ? $shop->id : null,
            'currency_id' => $currency->id,
            'name'        => $row['name'],
            'is_default'  => $row['is_default'] ?? 0,
            'start_date'  => $row['start_date'] ?? null,
            'end_date'    => $row['end_date'] ?? null,
            'status'      => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string',
            'currency_code' => 'required|string',
        ];
    }
}