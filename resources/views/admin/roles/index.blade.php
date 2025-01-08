<x-admin-layout>
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Breadcrumbs -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Role's</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="container-xl px-4">
                <!-- Space between breadcrumb and form -->
                <div class="mb-4"></div>

                <!-- Start Page-content-Wrapper -->
            <!-- end page title -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


            <!-- Start Page-content-Wrapper -->
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <div class="table-responsive">

                                <div class="table-responsive">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title">Role's</h4>


                                        @can('add roles')

                                        <div class="ml-auto d-flex align-items-center">
                                            <a href="/role-add" class="btn btn-primary ml-2" style="width: 40px;" data-toggle="tooltip" data-placement="top" title="Add Role"><i class="fas fa-plus"></i></a>
                                        </div>
                                        @endcan
                                    </div>
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                                <div class="table-responsive">
                                    <table class="table table-editable table-nowrap align-middle table-edits">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Role Name</th>
                                                <th>Guard Name </th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="tableBody" >
                                            @foreach ( $list as $product)
                                            <tr>
                                                <td>{{$product->id}}</td>
                                                <td>{{$product->name }}</td>
                                                <td>{{$product->guard_name  }}</td>
                                                <td>
                                                @can('addPermissiontorole roles')

                                                    <a class="btn btn-success waves-light btn-sm" href="{{ route('addPermissionToRole', ['encryptedId' => Crypt::encryptString($product->id)]) }}" data-toggle="tooltip" data-placement="top" title="Add Permission"><i class="fa-regular fa-circle-user"></i></i></a>
                                                    @endcan
                                                    @can('edit roles')

                                                    <a class="btn btn-warning btn-sm" href="{{ route('role.edit', ['encryptedId' => Crypt::encryptString($product->id)]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    @endcan
                                                    @can('delete roles')

                                                    <form id="deleteForm{{$product->id}}" action="{{ route('role.destroy', ['id' => $product->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(event, {{$product->id}})" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                    @endcan
                                                </td>


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Content Wrapper-->
        </div>
        <!-- Container-Fluid -->
    </div>
    <!-- End Page-content -->
</div>



<script>
    function confirmDelete(event, id) {
        // Prevent default form submission
        event.preventDefault();

        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            // If user confirms deletions
            if (result.isConfirmed) {
                // Submit the form
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }

    // This function will be called when the document is ready
    $(document).ready(function() {
        // Check if there is a success message in the session
        var successMessage = "{{ session('success') }}";
        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: successMessage,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
</script>


</x-admin-layout>
