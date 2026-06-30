<div class="modal fade" id="createPermissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.permissions.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Permission Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required 
                               placeholder="e.g., View Customers">
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Permission Slug *</label>
                        <input type="text" class="form-control" id="slug" name="slug" required 
                               placeholder="e.g., view-customers">
                    </div>
                    
                    <div class="mb-3">
                        <label for="module" class="form-label">Module *</label>
                        <select class="form-control" id="module" name="module" required>
                            <option value="">Select Module</option>
                            <option value="dashboard">Dashboard</option>
                            <option value="customers">Customers</option>
                            <option value="orders">Orders</option>
                            <option value="credits">Credits</option>
                            <option value="payments">Payments</option>
                            <option value="vendors">Vendors</option>
                            <option value="expenses">Expenses</option>
                            <option value="shops">Shops</option>
                            <option value="reports">Reports</option>
                            <option value="settings">Settings</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Permission Type *</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="menu">Menu (Shows in navigation)</option>
                            <option value="page">Page (Access to page)</option>
                            <option value="action">Action (CRUD operations)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="menu_id" class="form-label">Link to Menu (Optional)</label>
                        <select class="form-control" id="menu_id" name="menu_id">
                            <option value="">None</option>
                            @foreach(App\Models\Menu::all() as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>