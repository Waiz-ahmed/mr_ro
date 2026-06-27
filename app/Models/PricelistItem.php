<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricelistItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pricelist_items';

    protected $fillable = [
        'pricelist_id', 'product_id', 'category_id', 'min_qty',
        'compute_method', 'price', 'discount_pct', 'price_formula',
        'date_start', 'date_end', 'status'
    ];

    protected $casts = [
        'min_qty'       => 'decimal:4',
        'price'         => 'decimal:2',
        'discount_pct'  => 'decimal:2',
        'date_start'    => 'date',
        'date_end'      => 'date',
    ];

    public function pricelist()
    {
        return $this->belongsTo(Pricelist::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}