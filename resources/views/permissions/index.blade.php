@extends('layouts.master')

@section('title', 'Permission Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permission Management</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="fa fa-plus"></i> New Role
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                            <i class="fa fa-plus"></i> New Permission
                        </button>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            <i class="fa fa-user-plus"></i> New User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab">Roles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab">Permissions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="matrix-tab" data-bs-toggle="tab" data-bs-target="#matrix" type="button" role="tab">Permission Matrix</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content p-3" id="permissionTabsContent">
                        <!-- Roles Tab -->
                        @include('permissions.tabs.roles')
                        
                        <!-- Permissions Tab -->
                        @include('permissions.tabs.permissions')
                        
                        <!-- Users Tab -->
                        @include('permissions.tabs.users')
                        
                        <!-- Matrix Tab -->
                        @include('permissions.tabs.matrix')

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
@include('permissions.modals.create-role')

<!-- Create Permission Modal -->
@include('permissions.modals.create-permission')

<!-- Assign Permission Modal -->
@include('permissions.modals.assign-permission')

<!-- Create User Modal -->
@include('permissions.modals.create-user')

<!-- Assign Roles Modal -->
@include('permissions.modals.assign-role')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle role selection for permission assignment
        $('.assign-permissions-btn').click(function() {
            var roleId = $(this).data('role-id');
            var roleName = $(this).data('role-name');
            $('#assignPermissionModal').find('.modal-title').text('Assign Permissions to ' + roleName);
            $('#assign_role_id').val(roleId);
            
            // Load permissions for this role
            $.get('/admin/roles/' + roleId + '/permissions', function(data) {
                // Populate permissions checkboxes
                // This will be implemented based on your UI
            });
        });
        
        // Check/uncheck all permissions in a module
        $('.check-all').click(function() {
            var module = $(this).data('module');
            $('.' + module + '-permission').prop('checked', $(this).prop('checked'));
        });

        // Handle user selection for role assignment
        $('.assign-roles-btn').click(function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');
            $('#assignRolesModal').find('.modal-title').text('Assign Roles to ' + userName);
            $('#assign_user_id').val(userId);
            
            // Load current roles for this user
            $.get('/admin/users/' + userId + '/roles', function(data) {
                // Uncheck all first
                $('.role-checkbox').prop('checked', false);
                
                // Check the ones that belong to this user
                data.roles.forEach(function(roleId) {
                    $('#role_' + roleId).prop('checked', true);
                });
            });
        });
    });
</script>
@endpush