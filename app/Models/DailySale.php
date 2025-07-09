<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $fillable = [
        'item',
        'amount',
        'quantity',
        'total_amount',
        'customer_id',
        'is_credit',
        'sale_date',
        'month',
        'year',
        'shop_id',
    ];



}
