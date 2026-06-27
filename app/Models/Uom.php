<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'uom';

    protected $fillable = [
        'category_id',
        'name',
        'ratio',
        'is_base',
        'rounding',
        'status',
    ];

    protected $casts = [
        'ratio'    => 'decimal:6',
        'rounding' => 'decimal:6',
        'is_base'  => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(UomCategory::class, 'category_id');
    }
}