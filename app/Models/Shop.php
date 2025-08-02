<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'location', 'user_id'];


    public function fbrSetting()
    {
        return $this->hasOne(FbrSetting::class);
    }

}
