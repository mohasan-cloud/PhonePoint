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
                                    <h4 class="mb-0">Edit expenses</h4>
                                </div>
                                <div class="card-body">
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="item_name">Item Name</label>
            <input type="text" name="item_name" class="form-control" value="{{ $expense->item_name }}" required>
        </div>
        <div class="form-group">
            <label for="cost">Cost</label>
            <input type="number" name="cost" class="form-control" value="{{ $expense->cost }}" required>
        </div>
        <div class="form-group">
            <label for="expense_type">Expense Type</label>
            <select name="expense_type" class="form-control" required>
                                <option value="guest" {{ $expense->expense_type == 'guest' ? 'selected' : '' }}>Guest</option>

                <option value="purchase" {{ $expense->expense_type == 'purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="maintenance" {{ $expense->expense_type == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="others" {{ $expense->expense_type == 'others' ? 'selected' : '' }}>Others</option>
            </select>
        </div>
       
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $expense->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</x-admin-layout>
