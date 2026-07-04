<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = ['name', 'description', 'parent_id', 'status'];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function templates()
    {
        return $this->hasMany(ProductTemplate::class, 'category_id');
    }

    public function productsCount()
    {
        return $this->templates()->withCount('products')->get()->sum('products_count');
    }
}