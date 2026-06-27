<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'template_id', 'sku', 'barcode', 'weight', 'volume', 'image',
        'extra_price', 'status'
    ];

    protected $casts = [
        'weight'      => 'decimal:4',
        'volume'      => 'decimal:4',
        'extra_price' => 'decimal:2',
    ];

    public function template()
    {
        return $this->belongsTo(ProductTemplate::class, 'template_id');
    }
}