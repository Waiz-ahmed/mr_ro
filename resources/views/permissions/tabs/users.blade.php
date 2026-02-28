<div class="mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="fa fa-user-plus"></i> Create New User
    </button>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Current Role</th>
            <th>Assigned Roles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->role)
                    <span class="badge bg-{{ $user->role == 'super-admin' ? 'danger' : ($user->role == 'admin' ? 'warning' : 'info') }}">
                        {{ $user->role }}
                    </span>
                @else
                    <span class="badge bg-secondary">Not set</span>
                @endif
            </td>
            <td>
                @foreach($user->roles as $role)
                    <span class="badge bg-{{ $role->name == 'super-admin' ? 'danger' : ($role->name == 'admin' ? 'warning' : 'info') }} mb-1">
                        {{ $role->display_name ?? $role->name }}
                    </span>
                @endforeach
            </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary assign-roles-btn" 
                            data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#assignRolesModal">
                        <i class="fa fa-user-tag"></i> Assign Roles
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>