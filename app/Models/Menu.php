<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'icon',
        'route',
        'order',
        'parent_id',
        'status',
        'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}