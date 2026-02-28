<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Policies\CustomerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Customer::class, CustomerPolicy::class);
        
        // Blade directive for checking permissions
        Blade::if('permission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
        
        // Blade directive for checking roles
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });
        
        // Blade directive for checking any permission from a list
        Blade::if('anypermission', function ($permissions) {
            if (!auth()->check()) {
                return false;
            }
            
            $permissions = is_array($permissions) ? $permissions : explode('|', $permissions);
            
            foreach ($permissions as $permission) {
                if (auth()->user()->hasPermission(trim($permission))) {
                    return true;
                }
            }
            
            return false;
        });
        
        // Blade directive for checking all permissions
        Blade::if('allpermissions', function ($permissions) {
            if (!auth()->check()) {
                return false;
            }
            
            $permissions = is_array($permissions) ? $permissions : explode('|', $permissions);
            
            foreach ($permissions as $permission) {
                if (!auth()->user()->hasPermission(trim($permission))) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Blade directive for menu access
        Blade::if('menuaccess', function ($route) {
            return auth()->check() && auth()->user()->canAccessMenu($route);
        });
    }
}