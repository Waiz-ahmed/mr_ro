<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $fillable = [
        'item', 'amount', 'quantity', 'customer_id', 'is_credit'
    ];

}
