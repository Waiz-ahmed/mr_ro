<div class="tab-pane fade" id="permissions" role="tabpanel">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Module</th>
                <th>Type</th>
                <th>Menu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $module => $modulePermissions)
                <tr class="bg-light">
                    <td colspan="7"><strong>{{ ucfirst($module) }}</strong></td>
                </tr>
                @foreach($modulePermissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td><code>{{ $permission->slug }}</code></td>
                    <td>{{ $permission->module }}</td>
                    <td>
                        @if($permission->type == 'menu')
                            <span class="badge bg-primary">Menu</span>
                        @elseif($permission->type == 'page')
                            <span class="badge bg-info">Page</span>
                        @else
                            <span class="badge bg-success">Action</span>
                        @endif
                    </td>
                    <td>{{ $permission->menu->name ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>