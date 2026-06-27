<?php

namespace App\Imports;

use App\Models\Uom;
use App\Models\UomCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UomsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $category = UomCategory::where('name', $row['category_name'])->first();
        if (!$category) {
            throw new \Exception("UOM Category '{$row['category_name']}' not found");
        }

        return new Uom([
            'category_id' => $category->id,
            'name'        => $row['name'],
            'ratio'       => $row['ratio'] ?? 1,
            'is_base'     => $row['is_base'] ?? 0,
            'rounding'    => $row['rounding'] ?? 0.01,
            'status'      => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|string',
            'name'          => 'required|string',
            'ratio'         => 'nullable|numeric',
            'is_base'       => 'nullable|boolean',
        ];
    }
}