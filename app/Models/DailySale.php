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
        'sale_date',
        'customer_id',
        'is_credit',
    ];


}
