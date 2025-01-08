<x-admin-layout>
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

    <div class="page-wrapper">
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-md-12 px-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-warning text-white">
                                    <h4 class="mb-0">Edit Discount</h4>
                                </div>
                                <div class="card-body">
    <form action="{{ route('discounts.update', $discount) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $discount->name }}" required>
        </div>
        <div class="form-group">
            <label for="percentage">Percentage</label>
            <input type="number" name="percentage" id="percentage" class="form-control" value="{{ $discount->percentage }}" min="0" max="100" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Update</button>
    </form>
</div>
</x-admin-layout>