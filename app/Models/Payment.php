<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'customer_id',
        'payment_date',
        'amount_paid',
        'payment_method',
        'note',
    ];

}
