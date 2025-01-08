<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="px-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Discounts List</h4>
                                @can('add discounts')
                                <a href="{{ route('discounts.create') }}" class="btn btn-primary mb-3">Add Discount</a>
                                @endcan
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Percentage</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($discounts as $discount)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $discount->name }}</td>
                                            <td>{{ $discount->percentage }}%</td>
                                            <td>
                                                <button class="btn btn-sm toggle-status-btn {{ $discount->status === 'active' ? 'btn-success' : 'btn-secondary' }}" 
                                                    data-id="{{ $discount->id }}">
                                                    {{ ucfirst($discount->status) }}
                                                </button>
                                            </td>
                                            <td>
                                                @can('edit discounts')
                                                <a href="{{ route('discounts.edit', $discount) }}" class="btn btn-warning btn-sm">Edit</a>
                                                @endcan
                                                @can('delete discounts')
                                                <form action="{{ route('discounts.destroy', $discount) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', function () {
                const discountId = this.getAttribute('data-id');
                const button = this;

                fetch(`/discounts/${discountId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button text and style
                        button.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        button.classList.toggle('btn-success', data.status === 'active');
                        button.classList.toggle('btn-secondary', data.status === 'blocked');

                        // Display toast notification
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: 'error',
                            title: 'Failed to update status.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        toast: true,
                        position: 'top',
                        icon: 'error',
                        title: 'An error occurred. Please try again.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            });
        });
    });
</script>

</x-admin-layout>
