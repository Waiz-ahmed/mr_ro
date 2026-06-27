<?php

namespace App\Imports;

use App\Models\Currency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CurrenciesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Currency([
            'code'          => $row['code'],
            'name'          => $row['name'],
            'symbol'        => $row['symbol'] ?? null,
            'exchange_rate' => $row['exchange_rate'] ?? 1,
            'is_default'    => $row['is_default'] ?? 0,
            'status'        => $row['status'] ?? 'active',
        ]);
    }
}