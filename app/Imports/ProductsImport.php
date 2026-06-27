<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTemplate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $template = ProductTemplate::where('name', $row['template_name'])->first();
        if (!$template) throw new \Exception("Template '{$row['template_name']}' not found");

        return new Product([
            'template_id' => $template->id,
            'sku'         => $row['sku'] ?? null,
            'barcode'     => $row['barcode'] ?? null,
            'weight'      => $row['weight'] ?? null,
            'volume'      => $row['volume'] ?? null,
            'image'       => $row['image'] ?? null,
            'extra_price' => $row['extra_price'] ?? 0,
            'status'      => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'template_name' => 'required|string',
            'sku'           => 'nullable|string',
        ];
    }
}