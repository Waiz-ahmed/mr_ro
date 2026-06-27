<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Country([
            'name'       => $row['name'],
            'code'       => $row['code'] ?? null,
            'phone_code' => $row['phone_code'] ?? null,
            'status'     => $row['status'] ?? 'active',
        ]);
    }
}