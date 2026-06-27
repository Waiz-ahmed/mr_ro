<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricelist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pricelists';

    protected $fillable = [
        'shop_id', 'currency_id', 'name', 'is_default',
        'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items()
    {
        return $this->hasMany(PricelistItem::class);
    }
}