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
                                <li class="breadcrumb-item active" aria-current="page">Edit Module</li>
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
                                    <h5 class="card-title mb-4 text-center">Edit Role</h5>
                                <form id="permission_form" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">Role Name<span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $edit->name}}" id="name" class="form-control" placeholder="name Name" required>
                                                <div class="invalid-feedback">Please provide a valid full name.</div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Row -->
                                    <button class="btn btn-primary btn-sm" id="updateButton" type="button">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Your JavaScript code here
        document.getElementById("updateButton").addEventListener("click", function() {
            // Perform form validation
            var isValid = true;

            $('.error-message').remove();

            var name = $('#name').val();
            if (!name) {
                $('#name').after('<div class="error-message" style="color: red;">Role Name is required.</div>');
                isValid = false;
            }

            if (isValid) {
                // If form is valid, confirm submission
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to Update this Role!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Updated it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form via AJAX
                        $.ajax({
                            url: '/role/update/{{ $edit->id }}',
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
                                    window.location.href = "/role-list";
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle errors here
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: xhr.responseJSON.message
                                    });
                                } else {
                                    console.error(xhr.responseText);
                                }
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
