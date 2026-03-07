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
                            <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab" style="color: black !important;">Roles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions" type="button" role="tab" style="color: black !important;">Permissions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" style="color: black !important;">Users</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="matrix-tab" data-bs-toggle="tab" data-bs-target="#matrix" type="button" role="tab" style="color: black !important;">Permission Matrix</button>
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
        $('.assign-permissions-btn').on('click', function() {

            let roleId = $(this).data('role-id');
            let roleName = $(this).data('role-name');

            $('#assignPermissionModal .modal-title')
                .text('Assign Permissions to ' + roleName);

            $('#assign_role_id').val(roleId);

            // SET FORM ACTION CORRECTLY
            let actionUrl = '/admin/roles/' + roleId + '/permissions';

            $('#assignPermissionForm').attr('action', actionUrl);

            // Load current permissions
            $.get('/admin/roles/' + roleId + '/permissions', function(data) {

                $('.permission-item').prop('checked', false);

                if (data.permissions) {
                    data.permissions.forEach(function(permissionId) {
                        $('#perm_' + permissionId).prop('checked', true);
                    });
                }

            });

        });

        // Check/uncheck all permissions in a module
        $('.check-all-module').click(function() {
            var module = $(this).data('module');
            $('.' + module + '-permission').prop('checked', $(this).prop('checked'));
        });

        // Handle user selection for role assignment
        $('.assign-roles-btn').on('click', function() {

            let userId = $(this).data('user-id');
            let userName = $(this).data('user-name');

            $('#assignRolesModal .modal-title')
                .text('Assign Roles to ' + userName);

            $('#assign_user_id').val(userId);

            // SET FORM ACTION
            let actionUrl = '/admin/users/' + userId + '/roles';

            $('#assignRolesForm').attr('action', actionUrl);

            // Load user roles
            $.get('/admin/users/' + userId + '/roles', function(data) {

                $('.role-checkbox').prop('checked', false);

                if (data.roles) {
                    data.roles.forEach(function(roleId) {
                        $('#role_' + roleId).prop('checked', true);
                    });
                }

            });

        });
    });
</script>
@endpush