<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $parentId = null;
        if (!empty($row['parent_name'])) {
            $parent = ProductCategory::where('name', $row['parent_name'])->first();
            if ($parent) $parentId = $parent->id;
        }

        return new ProductCategory([
            'parent_id'   => $parentId,
            'name'        => $row['name'],
            'description' => $row['description'] ?? null,
            'status'      => $row['status'] ?? 'active',
        ]);
    }
}