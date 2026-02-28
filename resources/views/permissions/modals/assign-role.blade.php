<div class="modal fade" id="assignRolesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" id="assignRolesForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Assign Roles to User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="assign_user_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Select Roles</label>
                        @foreach($roles as $role)
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input role-checkbox" 
                                       name="roles[]" 
                                       value="{{ $role->id }}"
                                       id="role_{{ $role->id }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ $role->display_name ?? $role->name }}
                                    <small class="text-muted">({{ $role->name }})</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Roles</button>
                </div>
            </form>
        </div>
    </div>
</div>