<x-admin-layout>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Breadcrumb with Custom Styling -->
    <nav aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Classes</li>
        </ol>
    </nav>

    <!-- Right-Aligned Button Container -->
    <div class="d-flex justify-content-between align-items-center mb-3 mx-3">
        <h4>Class List</h4>
        @can('Classes Add')
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
            </a>
        @endcan
    </div>


    <!-- Modern Table for listing classes -->
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered border-primary">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Class Name</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td class="text-center">
                            @can('Classes Edit')
                                <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning btn-sm mx-1" title="">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan

                            @can('Classes Delete')
                                <form action="{{ route('classes.destroy', $class) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1" title="">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Custom CSS for Breadcrumb and Table -->
    <style>
        .custom-breadcrumb {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
        }

        .custom-breadcrumb .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .custom-breadcrumb .breadcrumb-item.active {
            color: #6c757d;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2; /* Light gray for odd rows */
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef; /* Light hover effect */
        }

        .table-bordered {
            border: 1px solid #dee2e6; /* Border around table */
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6; /* Border between cells */
        }
    </style>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlXzYUC+bgJQ0CVFnDqd7Ck/h8z1wcgfA/OoSMO7HC8VpLB8/+ELP9Nw2R9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWrZxlMwSXp+tQ3lgdPHK6u9EJ9f8aCHr/nApK5K0mK5tKk8AkwK07TLPX" crossorigin="anonymous"></script>
</x-admin-layout>
