<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'slug',
        'module',
        'action',
        'type',
        'menu_id',
        'description',
        'status',
        'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role')
                    ->withPivot('assigned_by')
                    ->withTimestamps();
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}