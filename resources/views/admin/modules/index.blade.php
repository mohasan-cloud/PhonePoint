<x-admin-layout>

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Breadcrumbs -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Modules</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

    <div class="container-xl px-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">{{__('Modules List')}}</div>
                    <div class="col-md-2">
                        <div class="input-group input-group-joined border-0 add-button">
                            <a class="btn btn-danger btn-sm" href="{{url('admin/add-module')}}">{{__('Add New Module')}}</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                @if(session()->has('message.added'))
                <div class="alert alert-{!! session('message.added') !!} alert-dismissible fade show" role="alert">
                  <strong>{{__('Congratulations')}}!</strong> {!! session('message.content') !!}.
                </div>
                @endif
                <input type="hidden" id="table-modules-url" value="{!! Request::url() !!}">
                <input type="hidden" id="is_enable_modules_action" value="{!! (in_array('modules.edit',permissions()) || in_array('modules.destroy',permissions()))?'yes':'no' !!}">
                <table class="table table-bordered" id="table-modules">
                  <thead>
                     <tr>
                        <th>Module Name</th>
                        <th>Module Term</th>
                        <th>Link</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @if($modules)
                     @foreach($modules as $module)
                     <tr>
                        <td>{{$module->name}}</td>
                        <td>{{$module->term}}</td>
                        <td><a href="{{ route('admin.modules.data',$module->slug)}}">Link</a></td>
                        <td>
                            <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#assignRoleModal"
                            data-module-id="{{ $module->id }}"
                            data-module-name="{{ $module->name }}">
                            Assign Role to Permission
                        </button>


                           <a class="btn btn-success btn-sm" href="{{route('admin.modules.edit',$module->id)}}" role="button">Edit</a>
                           <a class="btn btn-danger delete btn-sm" href="{{route('admin.modules.delete',$module->id)}}" role="button">Delete</a>
                        </td>
                     </tr>
                     @endforeach
                     @endif
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

    </div>
<!-- Modal -->
<div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignRoleModalLabel">Permissions for Module: <span id="moduleName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="permissionsList" class="text-center">
                    <!-- Permissions will be loaded here -->
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="savePermissionsBtn">Save Permissions</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const assignRoleModal = document.getElementById('assignRoleModal');

    assignRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const moduleName = button.getAttribute('data-module-name');

        document.getElementById('moduleName').textContent = moduleName;

        const permissionsList = document.getElementById('permissionsList');
        permissionsList.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

        fetch(`/permissions-by-module?module_name=${moduleName}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const table = document.createElement('table');
                    table.className = 'table table-bordered';
                    const thead = `<thead>
                        <tr>
                            <th>Permission</th>
                            ${data.roles.map(role => `<th>${role.name}</th>`).join('')}
                        </tr>
                    </thead>`;
                    const tbody = data.permissions.map(permission => `
                        <tr>
                            <td>${permission.name}</td>
                            ${permission.roles.map(role => `
                                <td>
                                    <input type="checkbox" 
                                           data-permission-id="${permission.id}" 
                                           data-role-id="${role.id}" 
                                           ${role.is_assigned ? 'checked' : ''}>
                                </td>`).join('')}
                        </tr>
                    `).join('');
                    table.innerHTML = thead + tbody;
                    permissionsList.innerHTML = '';
                    permissionsList.appendChild(table);
                } else {
                    permissionsList.innerHTML = `<p class="text-danger">${data.message}</p>`;
                }
            })
            .catch(error => {
                permissionsList.innerHTML = `<p class="text-danger">An error occurred: ${error.message}</p>`;
            });
    });

    document.getElementById('savePermissionsBtn').addEventListener('click', function () {
        const selectedPermissions = [];
        document.querySelectorAll('[data-permission-id]').forEach(input => {
            selectedPermissions.push({
                permission_id: input.getAttribute('data-permission-id'),
                role_id: input.getAttribute('data-role-id'),
                is_assigned: input.checked,
            });
        });

        // Show the processing SweetAlert
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we save permissions.',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`/save-permissions`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ permissions: selectedPermissions })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Close the modal and reload the page
                    $('#assignRoleModal').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to save permissions.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error',
                text: 'An error occurred: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
});

</script>

</x-admin-layout>
