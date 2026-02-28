<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;

class CustomerPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-customers');
    }
    
    public function view(User $user, Customer $customer)
    {
        return $user->hasPermission('view-customers');
    }
    
    public function create(User $user)
    {
        return $user->hasPermission('create-customer');
    }
    
    public function update(User $user, Customer $customer)
    {
        return $user->hasPermission('edit-customer');
    }
    
    public function delete(User $user, Customer $customer)
    {
        return $user->hasPermission('delete-customer');
    }
}