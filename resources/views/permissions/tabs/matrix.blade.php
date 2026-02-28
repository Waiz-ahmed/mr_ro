<div class="tab-pane fade" id="matrix" role="tabpanel">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 300px;">Menu / Permission</th>
                    @foreach($roles as $role)
                        <th class="text-center">
                            {{ $role->display_name ?? $role->name }}
                            <br>
                            <small>
                                <a href="#" class="check-all-role" data-role="{{ $role->id }}">Check All</a>
                            </small>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                    <tr class="table-primary">
                        <td colspan="{{ count($roles) + 1 }}">
                            <strong>
                                <i class="fa {{ $menu->icon }}"></i>
                                {{ $menu->name }}
                            </strong>
                        </td>
                    </tr>
                    
                    @foreach($menu->permissions as $permission)
                        <tr>
                            <td>↳ {{ $permission->name }} <small>({{ $permission->type }})</small></td>
                            @foreach($roles as $role)
                                <td class="text-center">
                                    <input type="checkbox" 
                                           class="permission-checkbox role-{{ $role->id }}"
                                           data-role="{{ $role->id }}"
                                           data-permission="{{ $permission->id }}"
                                           {{ $role->hasPermission($permission->slug) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    
                    @foreach($menu->children as $child)
                        <tr class="table-info">
                            <td colspan="{{ count($roles) + 1 }}">
                                <i class="fa fa-angle-right"></i>
                                {{ $child->name }}
                            </td>
                        </tr>
                        
                        @foreach($child->permissions as $permission)
                            <tr>
                                <td>&nbsp;&nbsp;&nbsp;↳ {{ $permission->name }}</td>
                                @foreach($roles as $role)
                                    <td class="text-center">
                                        <input type="checkbox" 
                                               class="permission-checkbox role-{{ $role->id }}"
                                               data-role="{{ $role->id }}"
                                               data-permission="{{ $permission->id }}"
                                               {{ $role->hasPermission($permission->slug) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    
    <button class="btn btn-primary" id="savePermissionMatrix">
        <i class="fa fa-save"></i> Save All Changes
    </button>
</div>