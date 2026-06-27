<?php

namespace App\Imports;

use App\Models\UomCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UomCategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new UomCategory([
            'name'   => $row['name'],
            'status' => $row['status'] ?? 'active',
        ]);
    }
}