<x-admin-layout>
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('permissions.list') }}">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
                    </ol>
                </nav>
            </div>

            <!-- Form Section -->
            <div class="container-xxl">
                <div class="page-content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10 col-sm-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-center">Create Permission</h5>
                                    <form id="permission_form" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Permission Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Permission Name" required>
                                        <div class="invalid-feedback">Please provide a valid permission name.</div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary btn-sm" id="submitButton" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- End Page-content-Wrapper -->

    </div><!-- End container-fluid -->
</div><!-- End Page-content -->
@push('js')
<script>
    $(document).ready(function() {
        // Handle form submit via AJAX
        $("#permission_form").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Perform form validation
            var isValid = true;
            $('.error-message').remove(); // Clear existing error messages

            var name = $('#name').val();
            if (!name) {
                $('#name').after('<div class="error-message" style="color: red;">Permission Name is required.</div>');
                isValid = false;
            }

            if (isValid) {
                // Confirm before submitting the form
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to create this Permission!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form via AJAX
                        $.ajax({
                            url: '{{ route('permissions.store') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: $('#permission_form').serialize(), // Serialize the form data
                            success: function(response) {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    // Redirect to the permissions list page
                                    window.location.href = "{{ route('permissions.list') }}";
                                });
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = '';
                                if(xhr.status == 422) {
                                    // Validation error (e.g., permission already exists)
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
