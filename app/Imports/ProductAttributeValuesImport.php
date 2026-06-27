<?php

namespace App\Imports;

use App\Models\ProductAttributeValue;
use App\Models\ProductAttribute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductAttributeValuesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $attribute = ProductAttribute::where('name', $row['attribute_name'])->first();
        if (!$attribute) throw new \Exception("Attribute '{$row['attribute_name']}' not found");

        return new ProductAttributeValue([
            'attribute_id' => $attribute->id,
            'value'        => $row['value'],
            'status'       => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'attribute_name' => 'required|string',
            'value'          => 'required|string',
        ];
    }
}