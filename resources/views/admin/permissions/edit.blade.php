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
                                    <h5 class="card-title mb-4 text-center">Update Permission</h5>
                                    <form id="permission_form" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label" for="name">Permission Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $edit->name) }}" id="name" class="form-control" placeholder="Enter permission name" required>
                                            <div class="invalid-feedback">Please provide a valid permission name.</div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary btn-sm" id="updateButton" type="button">Update</button>
                                        </div>
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
            // Form submission and validation
            document.getElementById("updateButton").addEventListener("click", function() {
                var isValid = true;
                $('.error-message').remove();

                var name = $('#name').val();
                if (!name) {
                    $('#name').after('<div class="error-message" style="color: red;">Permission Name is required.</div>');
                    isValid = false;
                }

                if (isValid) {
                    // Confirmation dialog before submitting
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to update this Permission!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // AJAX form submission
                            $.ajax({
                                url: '/permissions/update/{{ $edit->id }}',
                                type: 'POST',
                                dataType: 'json',
                                data: $('#permission_form').serialize(),
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location.href = "/permissions-list";
                                    });
                                },
                                error: function(xhr) {
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
