<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    // Add to app/Models/User.php
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    public function hasPermission($permissionSlug)
    {
        // Super admin has all permissions
        if ($this->hasRole('super-admin')) {
            return true;
        }
        
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permissionSlug)) {
                return true;
            }
        }
        
        return false;
    }

    public function canAccessMenu($menuRoute)
    {
        // Super admin has access to all menus
        if ($this->hasRole('super-admin')) {
            return true;
        }
        
        // Check if user has any permission that grants access to this menu
        $permissions = Permission::whereHas('menu', function($query) use ($menuRoute) {
            $query->where('route', $menuRoute);
        })->where('type', 'menu')->get();
        
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission->slug)) {
                return true;
            }
        }
        
        return false;
    }
}
