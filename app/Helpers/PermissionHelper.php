<?php

if (!function_exists('can')) {
    function can($permission)
    {
        if (auth()->check()) {
            return auth()->user()->hasPermission($permission);
        }
        return false;
    }
}

if (!function_exists('can_access')) {
    function can_access($route)
    {
        if (auth()->check()) {
            return auth()->user()->canAccessMenu($route);
        }
        return false;
    }
}