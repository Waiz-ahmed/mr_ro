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

    // DailySale Model
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function creditCustomer()
    {
        return $this->belongsTo(CreditCustomer::class, 'customer_id');
    }
    
}
