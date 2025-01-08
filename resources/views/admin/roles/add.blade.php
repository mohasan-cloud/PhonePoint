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
                                <li class="breadcrumb-item"><a href="{{ url('/admin/modules')}}">Modules</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Module</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="container-xxl">
                <div class="page-content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 col-sm-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-center">Create Role</h5>

                                    <form id="permission_form" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="name">Role Name<span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Role Name" required>
                                                    <div class="invalid-feedback">Please provide a valid full name.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Row -->
                                        <button class="btn btn-primary btn-sm" id="submitButton" type="button">Submit Form</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page-content-Wrapper -->
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

            var name = $('#name').val();
            if (!name) {
                $('#name').after('<div class="error-message" style="color: red;">Permission Name is required.</div>');
                isValid = false;
            }

            if (isValid) {
                // If form is valid, confirm submission
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to create this Role!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form via AJAX
                        $.ajax({
                            url: '{{ route('role.store') }}',
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
            }
        });
    });
</script>
@endpush
</x-admin-layout>
