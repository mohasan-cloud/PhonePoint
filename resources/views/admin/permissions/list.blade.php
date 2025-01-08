<x-admin-layout>

    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                </div>
            </div>

            <div class="container-xxl">
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
                @can('add permission')

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">Permissions</h1>
                    <a href="{{ url('/permissions-add') }}" class="btn btn-primary btn-sm">Add Permission</a>
                </div>
                @endcan
                <!-- Permissions Table -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="permissionsTable" class="table table-bordered table-striped table-hover" style="width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Permission Name</th>
                                    <th>Guard Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach($list as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->guard_name}}</td>
                                    <td>
                                    @can('edit permission')

                                        <a class="btn btn-warning btn-sm" href="{{ route('permissions.edit', ['encryptedId' => Crypt::encryptString($product->id)]) }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @can('delete permission')

                                        <form id="deleteForm{{$product->id}}" action="{{ route('permissions.destroy', ['id' => $product->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(event, {{$product->id}})" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
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

    @push('css')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 10px;
        }
        .table th, .table td {
            padding: 1rem;
            text-align: center;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .table-hover tbody tr:hover {
            background-color: #e0e0e0;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn {
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
    @endpush

    @push('js')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#permissionsTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });

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

        function confirmDelete(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + id).submit();
                }
            });
        }
    </script>
    @endpush

</x-admin-layout>
