<x-admin-layout>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="px-4 col-md-12"">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Product List</h4>
                                    @can('add categories')
                                    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

                                    @endcan

                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <form method="GET" action="">
                                            <div class="input-group">
                                                <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search ?? '' }}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>

  
 
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                @can('edit categories')
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                    @endcan
                    @can('delete categories')
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-admin-layout>