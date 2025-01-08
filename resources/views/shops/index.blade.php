<x-admin-layout>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <!-- Card Header -->
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Shop List</h4>
                                @can('add shop')
                                <a href="{{ route('shops.create') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus"></i> Add Shop
                                </a>
                                @endcan
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Search Bar -->
                                <form action="{{ route('shops.index') }}" method="GET" class="mb-4">
                                    <div class="input-group">
                                        <input type="text" name="search" placeholder="Search by any field" class="form-control" value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </form>

                                <!-- Shop Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Shop Unique ID</th>
                                                <th>Shop Name</th>
                                                <th>Owner Name</th>
                                                <th>Shop Location</th>
                                                <th>Near Shop</th>
                                                <th>Reference Name</th>
                                                <th>Reference Shop</th>
                                                <th>CNIC Image</th>
                                                <th>Balance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($shops as $index => $shop)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                               <td> <p> {{ $shop->shop_unique_id }}</p></td>
                                                <td>{{ $shop->shop_name }}</td>
                                                <td>{{ $shop->owner_name }}</td>
                                                <td>{{ $shop->shop_location }}</td>
                                                <td>{{ $shop->near_shop }}</td>
                                                <td>{{ $shop->reference_name }}</td>
                                                <td>{{ $shop->reference_shop }}</td>
                                                <td>
                                                    @if($shop->cnic_image)
                                                    <a href="{{ asset( $shop->cnic_image) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td>{{ number_format($shop->balance, 2) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @can('edit shop')


                                                        <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-warning btn-sm me-2">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        @endcan
                                                        @can('delete shop')


                                                        <form action="{{ route('shops.destroy', $shop->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shop?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                            @endcan
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No shops found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $shops->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>
</x-admin-layout>
