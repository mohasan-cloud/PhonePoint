<x-admin-layout>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="px-4 col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Expense List</h4>
                                    @can('add expenses')
                                    <a href="{{ route('expenses.create') }}" class="btn btn-success">Add New Expense</a>
                                    @endcan
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('expenses.index') }}" method="GET" class="mb-4">
                                        <div class="row">
                                            <!-- Search by Username -->
                                            <div class="col-md-4">
                                                <input type="text" name="username" class="form-control" placeholder="Search by Username" value="{{ request('username') }}">
                                            </div>
                                            
                                            <!-- Search by Date Range -->
                                            <div class="col-md-3">
                                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                            </div>
                                            
                                            <!-- Submit Button -->
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- Total Cost -->
                                    <div class="alert alert-info">
                                        <strong>Total Cost:</strong> {{ number_format($totalCost, 2) }} PKR
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>User Name</th>
                                                    <th>Item Name</th>
                                                    <th>Cost</th>
                                                    <th>Expense Type</th>
                                                    <th>Expense Date</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $expense->item_name }}</td>
                                                    <td>{{ $expense->cost }}</td>
                                                    <td>{{ $expense->expense_type }}</td>
                                                    <td>{{ $expense->updated_at->format('d-m-Y') }}</td>
                                                    <td>{{ $expense->description }}</td>
                                                    <td>
                                                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                                                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $expenses->links() }} <!-- Pagination -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
