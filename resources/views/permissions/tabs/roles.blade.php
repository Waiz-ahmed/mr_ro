<div class="tab-pane fade show active" id="roles" role="tabpanel">
    <div class="row">
        @foreach($roles as $role)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header bg-{{ $role->name == 'super-admin' ? 'danger' : ($role->name == 'admin' ? 'warning' : 'info') }} text-white">
                    <h5 class="card-title mb-0">{{ $role->display_name ?? $role->name }}</h5>
                </div>
                <div class="card-body">
                    <p>{{ $role->description ?? 'No description' }}</p>
                    <p><strong>Slug:</strong> {{ $role->name }}</p>
                    <p><strong>Permissions:</strong> {{ $role->permissions->count() }}</p>
                    <p><strong>Users:</strong> {{ $role->users->count() }}</p>
                    
                    <div class="btn-group w-100">
                        <button class="btn btn-primary btn-sm assign-permissions-btn" 
                                data-role-id="{{ $role->id }}"
                                data-role-name="{{ $role->display_name ?? $role->name }}"
                                data-bs-toggle="modal" 
                                data-bs-target="#assignPermissionModal">
                            <i class="fa fa-key"></i> Assign Permissions
                        </button>
                        @if($role->name != 'super-admin' && $role->name != 'admin' && $role->name != 'staff')
                        <button class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>