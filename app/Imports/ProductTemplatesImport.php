<?php

namespace App\Imports;

use App\Models\ProductTemplate;
use App\Models\ProductCategory;
use App\Models\Uom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductTemplatesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $category = ProductCategory::where('name', $row['category_name'])->first();
        $uom = Uom::where('name', $row['uom_name'])->first();
        $uomPurchase = !empty($row['uom_purchase_name']) ? Uom::where('name', $row['uom_purchase_name'])->first() : null;

        return new ProductTemplate([
            'category_id'         => $category ? $category->id : null,
            'uom_id'              => $uom ? $uom->id : null,
            'uom_purchase_id'     => $uomPurchase ? $uomPurchase->id : null,
            'name'                => $row['name'],
            'internal_ref'        => $row['internal_ref'] ?? null,
            'barcode'             => $row['barcode'] ?? null,
            'type'                => $row['type'] ?? 'storable',
            'sale_price'          => $row['sale_price'] ?? 0,
            'cost_price'          => $row['cost_price'] ?? 0,
            'description'         => $row['description'] ?? null,
            'description_sale'    => $row['description_sale'] ?? null,
            'description_purchase'=> $row['description_purchase'] ?? null,
            'internal_notes'      => $row['internal_notes'] ?? null,
            'sale_ok'             => $row['sale_ok'] ?? 1,
            'purchase_ok'         => $row['purchase_ok'] ?? 1,
            'has_variants'        => $row['has_variants'] ?? 0,
            'track_inventory'     => $row['track_inventory'] ?? 1,
            'status'              => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'category_name' => 'nullable|string',
            'uom_name'      => 'required|string',
        ];
    }
}