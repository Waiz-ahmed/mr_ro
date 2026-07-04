<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'template_id', 'sku', 'barcode', 'weight', 'volume',
        'image', 'extra_price', 'status'
    ];

    public function template()
    {
        return $this->belongsTo(ProductTemplate::class, 'template_id');
    }
}