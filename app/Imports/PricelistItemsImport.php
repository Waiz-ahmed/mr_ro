<?php

namespace App\Imports;

use App\Models\PricelistItem;
use App\Models\Pricelist;
use App\Models\Product;
use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PricelistItemsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $pricelist = Pricelist::where('name', $row['pricelist_name'])->first();
        if (!$pricelist) throw new \Exception("Pricelist '{$row['pricelist_name']}' not found");

        $product = null;
        if (!empty($row['product_sku'])) {
            $product = Product::where('sku', $row['product_sku'])->first();
        }

        $category = null;
        if (!empty($row['category_name'])) {
            $category = ProductCategory::where('name', $row['category_name'])->first();
        }

        return new PricelistItem([
            'pricelist_id'   => $pricelist->id,
            'product_id'     => $product ? $product->id : null,
            'category_id'    => $category ? $category->id : null,
            'min_qty'        => $row['min_qty'] ?? 1,
            'compute_method' => $row['compute_method'] ?? 'fixed',
            'price'          => $row['price'] ?? null,
            'discount_pct'   => $row['discount_pct'] ?? null,
            'price_formula'  => $row['price_formula'] ?? null,
            'date_start'     => $row['date_start'] ?? null,
            'date_end'       => $row['date_end'] ?? null,
            'status'         => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'pricelist_name' => 'required|string',
            'compute_method' => 'in:fixed,discount,formula',
        ];
    }
}