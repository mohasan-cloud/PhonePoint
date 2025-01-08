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
                                <li class="breadcrumb-item active" aria-current="page">{{ $role->name }} </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="container-xl px-4">
                <!-- Space between breadcrumb and form -->
                <div class="mb-4"></div>



            <!-- end page title -->
            <!-- Start Page-content-Wrapper -->
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-4">Role Assign Permission</h2>
                                <form id="permission_form" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                                    @csrf

                                    <!-- Permissions Row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-3 mb-3">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input permission-checkbox"
                                                                name="permission[]"
                                                                type="checkbox"
                                                                value="{{ $permission->name }}"
                                                                {{ in_array($permission->id, $getpermissions) ? 'checked' : '' }}
                                                                id="permission{{ $permission->id }}">
                                                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                            <div class="invalid-feedback">Please select a permission.</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Permissions Row -->

                                    <!-- Submit Button -->
                                    <div class="mt-4 text-end">
                                        <button class="btn btn-primary btn-sm" id="submitButton" type="button">Submit Form</button>
                                    </div>
                                </form>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')

<script>
    $(document).ready(function() {
        $("#submitButton").click(function() {
            // Perform form validation
            var isValid = true;
            $('.error-message').remove();

            // If form is valid, confirm submission
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Assign {{ $role->name }} Role to their Permissions!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form via AJAX
                    $.ajax({
                        url: '/role/{{ $role->id }}/update-permission',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#permission_form').serialize(),
                        success: function(response) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                // Redirect to list page
                                window.location.href = "{{ route('role.list') }}";
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = '';
                            if(xhr.status == 422) {
                                // If validation error (e.g., permission already exists)
                                var response = xhr.responseJSON;
                                if(response.errors && response.errors.name) {
                                    errorMessage = response.errors.name[0];
                                } else {
                                    errorMessage = "Validation error occurred.";
                                }
                            } else {
                                // Other errors
                                errorMessage = "An unexpected error occurred.";
                            }

                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });
    });
</script>

@endpush
</x-admin-layout>


