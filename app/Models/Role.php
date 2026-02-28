<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'status',
        'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->withPivot('assigned_by', 'assigned_at')
                    ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
                    ->withPivot('assigned_by')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hasPermission($permissionSlug)
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }
}