<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_templates';

    protected $fillable = [
        'category_id', 'uom_id', 'uom_purchase_id', 'name', 'internal_ref',
        'barcode', 'type', 'sale_price', 'cost_price', 'description',
        'description_sale', 'description_purchase', 'internal_notes',
        'sale_ok', 'purchase_ok', 'has_variants', 'track_inventory', 'status'
    ];

    protected $casts = [
        'sale_price'     => 'decimal:2',
        'cost_price'     => 'decimal:2',
        'sale_ok'        => 'boolean',
        'purchase_ok'    => 'boolean',
        'has_variants'   => 'boolean',
        'track_inventory'=> 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    public function uomPurchase()
    {
        return $this->belongsTo(Uom::class, 'uom_purchase_id');
    }

    public function variants()
    {
        return $this->hasMany(Product::class, 'template_id');
    }
}