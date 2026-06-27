<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UomCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'uom_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // A category has many UOMs
    public function uoms()
    {
        return $this->hasMany(Uom::class, 'category_id');
    }
}