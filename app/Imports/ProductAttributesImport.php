<?php

namespace App\Imports;

use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductAttributesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ProductAttribute([
            'name'   => $row['name'],
            'status' => $row['status'] ?? 'active',
        ]);
    }
}