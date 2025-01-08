<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Uncomment and update this section if you need the Role Name field -->
         <div class="mb-3">
            <label for="name">Role Name</label>
            <input type="text" value='{{$role->name}}' name="name" class="form-control" id="name" placeholder="Role Name">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> 
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="mb-3">
            <label for="permissions">Assign Permissions</label>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="mb-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">
                                <input type="checkbox" id="all_permission">
                            </th>
                            <th scope="col" width="20%">Name</th>
                            <th scope="col" width="1%">Guard</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <input type="checkbox" name="permission[{{ $permission->name }}]" value="{{ $permission->name }}" class="permission" {{ isset($role) && in_array($permission->name, $role->permissions()->pluck('name')->toArray()) ? 'checked' : '' }}>
                                </td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>