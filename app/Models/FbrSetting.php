<?php

// app/Models/FbrSetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FbrSetting extends Model
{
    protected $fillable = [
        'shop_id',
        'pos_id',
        'integration_key',
        'client_id',
        'client_secret',
        'enabled',
    ];

    public $timestamps = true;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
