<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'expense_date',
        'vendor_id',
        'description',
        'amount',
        'shop_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
