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
        <!-- Page Content -->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-md-12 px-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-warning text-white">
                                    <h4 class="mb-0">store expenses</h4>
                                </div>
                                <div class="card-body">

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cost">Cost</label>
            <input type="number" name="cost" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="expense_type">Expense Type</label>
            <select name="expense_type" class="form-control" required>
            <option value="guest">Guest</option>

                <option value="purchase">Purchase</option>
                <option value="maintenance">Maintenance</option>
                <option value="others">Others</option>
            </select>
        </div>
       
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</x-admin-layout>