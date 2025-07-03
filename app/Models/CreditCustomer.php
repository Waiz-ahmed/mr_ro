<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCustomer extends Model
{

    protected $fillable = ['customer_id', 'daily_sale_id', 'balance'];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    public function dailySale()
    {
        return $this->belongsTo(DailySale::class, 'daily_sale_id');
    }


}
