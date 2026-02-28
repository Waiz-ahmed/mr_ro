<?php
// app/Http/Controllers/Admin/PermissionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Add this for password hashing

class PermissionController extends Controller
{
    /**
     * Show permission management dashboard
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::with('menu')->get()->groupBy('module');
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();
        $users = User::with('roles')->paginate(10);
        
        return view('permissions.index', compact('roles', 'permissions', 'menus', 'users'));
    }

    /**
     * Assign permissions to a role
     */
    public function assignToRole(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->permissions()->sync($request->permissions ?? []);
        
        return redirect()->back()->with('success', 'Permissions assigned to role successfully!');
    }

    /**
     * Assign roles to a user
     */
    public function assignToUser(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->roles()->sync($request->roles ?? []);
        
        return redirect()->back()->with('success', 'Roles assigned to user successfully!');
    }

    /**
     * Create a new role
     */
    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'nullable'
        ]);

        Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'created_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    /**
     * Delete a role
     */
    public function deleteRole(Role $role)
    {
        if (in_array($role->name, ['super-admin', 'admin', 'staff'])) {
            return redirect()->back()->with('error', 'Cannot delete system roles');
        }
        
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }

    /**
     * Create a new permission
     */
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'slug' => 'required|unique:permissions,slug',
            'module' => 'required',
            'type' => 'required|in:menu,page,action',
            'menu_id' => 'nullable|exists:menus,id'
        ]);

        Permission::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'module' => $request->module,
            'action' => $request->action ?? 'view',
            'type' => $request->type,
            'menu_id' => $request->menu_id,
            'created_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Permission created successfully!');
    }

    /**
     * Edit permission
     */
    public function editPermission(Permission $permission)
    {
        $menus = Menu::all();
        return view('permissions.edit-permission', compact('permission', 'menus'));
    }

    /**
     * Update permission
     */
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:permissions,slug,' . $permission->id,
            'module' => 'required',
            'type' => 'required|in:menu,page,action',
            'menu_id' => 'nullable|exists:menus,id'
        ]);
        
        $permission->update($request->all());
        
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Delete permission
     */
    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully');
    }

    /**
     * Get permissions for a specific menu (AJAX)
     */
    public function getMenuPermissions(Menu $menu)
    {
        $permissions = $menu->permissions;
        return response()->json($permissions);
    }

    /**
     * Get role permissions for AJAX
     */
    public function getRolePermissions(Role $role)
    {
        $permissions = $role->permissions->pluck('id');
        return response()->json(['permissions' => $permissions]);
    }

    /**
     * Get user roles for AJAX
     */
    public function getUserRoles(User $user)
    {
        $roles = $user->roles->pluck('id');
        return response()->json(['roles' => $roles]);
    }

    /**
     * Sync role permissions (for matrix save)
     */
    public function syncRolePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array'
        ]);
        
        $role->permissions()->sync($request->permissions ?? []);
        
        return response()->json(['success' => true]);
    }

    /**
     * Save entire permission matrix
     */
    public function saveMatrix(Request $request)
    {
        $data = $request->all();
        
        foreach ($data['roles'] as $roleId => $permissions) {
            $role = Role::find($roleId);
            if ($role) {
                $role->permissions()->sync($permissions);
            }
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('permissions.create-user', compact('roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'roles' => 'array',
            'legacy_role' => 'nullable|in:admin,staff'
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->legacy_role ?? 'staff'
        ]);
        
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        
        return redirect()->route('admin.permissions.index')->with('success', 'User created successfully');
    }

    /**
     * Edit user
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('permissions.edit-user', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'array',
            'legacy_role' => 'nullable|in:admin,staff'
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->legacy_role ?? $user->role
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }
        
        return redirect()->route('admin.permissions.index')->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'Cannot delete super admin user');
        }
        
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}