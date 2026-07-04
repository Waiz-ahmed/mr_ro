<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'product_templates';

    protected $fillable = [
        'category_id', 'uom_id', 'uom_purchase_id', 'name', 'internal_ref',
        'barcode', 'type', 'sale_price', 'cost_price', 'description',
        'sale_ok', 'purchase_ok', 'has_variants', 'track_inventory', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'template_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }
}