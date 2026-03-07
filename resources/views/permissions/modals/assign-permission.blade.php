<div class="modal fade" id="assignPermissionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="assignPermissionForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Assign Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" id="assign_role_id">
                    
                    <div class="row">
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input check-all-module" 
                                                   data-module="{{ $module }}">
                                            <label class="form-check-label fw-bold">
                                                {{ ucfirst($module) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($modulePermissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input permission-item {{ $module }}-permission"
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}"
                                                       id="perm_{{ $permission->id }}">
                                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                    <small class="text-muted">({{ $permission->type }})</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Permissions</button>
                </div>
            </form>
        </div>
    </div>
</div>