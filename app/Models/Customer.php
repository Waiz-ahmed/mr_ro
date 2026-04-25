<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'address', // your fields
    ];

    // App\Models\Customer.php
    public function creditCustomers()
    {
        return $this->hasMany(\App\Models\CreditCustomer::class);
    }

    public function dailySales()
    {
        return $this->hasMany(DailySale::class);
    }

}

