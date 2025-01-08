<x-admin-layout>
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">

                    <!-- Breadcrumbs -->
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Management</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- User Management Header -->
                    @can('add user')
                    <div class="col-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mb-0"></h2>
                            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Add User
                            </a>
                        </div>
                    </div>
                @endcan
                    <!-- Delete Selected Button -->
                    @can('delete user')
                    <div class="col-12 mb-3">
                        <button id="delete-selected" class="btn btn-danger btn-sm" >
                            <i class="fa fa-trash"></i> Delete Selected
                        </button>
                    </div>
                @endcan
                    <!-- User Table -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User List</h4>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <form id="bulk-delete-form" action="{{ route('users.bulkDelete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <table class="table table-bordered table-striped table-sm mb-0 table-centered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th><input type="checkbox" id="select-all" class="form-check-input"></th>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Second Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Username</th>
                                                    <th>Role</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    <tr>
                                                        <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox form-check-input"></td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->first_name }}</td>
                                                        <td>{{ $user->second_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone_number }}</td>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->roles->first()->name ?? 'No Role Assigned' }}</td>
                                                        <td class="text-end">
                                                        @can('edit user')
                                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            @endcan
                                                            @can('delete user')
                                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteSelectedButton = document.getElementById('delete-selected');
    const selectAllCheckbox = document.getElementById('select-all');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');

    // Enable or disable the Delete Selected button based on checkboxes
    function toggleDeleteButton() {
        const anyChecked = Array.from(userCheckboxes).some(checkbox => checkbox.checked);
        deleteSelectedButton.disabled = !anyChecked;
    }

    // Toggle all checkboxes when the Select All checkbox is clicked
    selectAllCheckbox.addEventListener('click', function() {
        const isChecked = this.checked;
        userCheckboxes.forEach(checkbox => checkbox.checked = isChecked);
        toggleDeleteButton();
    });

    // Check if Delete Selected button should be enabled/disabled
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleDeleteButton);
    });

    // Handle Delete Selected button click
    deleteSelectedButton.addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-delete-form').submit();
            }
        });
    });
});
</script>
@endpush
