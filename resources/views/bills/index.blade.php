

<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <style>
                .badge-primary {
                    font-size: 12px;
                    background: #3f51b5;
                    color: #fff;
                }
                .table thead th {
                    font-size: 16px;
                    background-color: #f8f9fa;
                    text-align: center;
                }
                .table tbody td {
                    font-size: 14px;
                    text-align: center;
                }
                .table-container {
                    overflow-x: auto;
                }
                .summary-card {
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    background: #f8f9fa;
                    transition: 0.3s;
                }
                .summary-card:hover {
                    transform: scale(1.02);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .summary-card h5 {
                    font-size: 18px;
                    margin: 0;
                }
                .summary-card .card-body h5 {
                    font-size: 20px;
                    font-weight: bold;
                }
                .search-bar input {
                    border-radius: 20px 0 0 20px;
                }
                .search-bar button {
                    border-radius: 0 20px 20px 0;
                }
            </style>

            <div class="px-4 col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-primary mb-0">Bills Overview</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings Summary -->
                    <div class="container my-4">
                        <div class="row g-4">
                            @can('todayearining')
                                <div class="col-md-3">
                                    <div class="card text-center summary-card">
                                        <div class="card-header bg-primary text-white">
                                            Today's Earnings
                                        </div>
                                        <div class="card-body bg-light">
                                            <h5 class="text-success">{{ number_format($todayEarnings, 2) }} PKR</h5>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                            @can('pendingbills')
                                <div class="col-md-3">
                                    <div class="card text-center summary-card">
                                        <div class="card-header bg-warning text-white">
                                            Pending Bills Total
                                        </div>
                                        <div class="card-body bg-light">
                                            <h5 class="text-danger">{{ number_format($pendingBillsTotal, 2) }} PKR</h5>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                            @can('weakeaning')
                                <div class="col-md-3">
                                    <div class="card text-center summary-card">
                                        <div class="card-header bg-info text-white">
                                            Weekly Earnings
                                        </div>
                                        <div class="card-body bg-light">
                                            <h5 class="text-success">{{ number_format($weeklyEarnings, 2) }} PKR</h5>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                            @can('totalearnign')
                                <div class="col-md-3">
                                    <div class="card text-center summary-card">
                                        <div class="card-header bg-success text-white">
                                            Monthly Earnings
                                        </div>
                                        <div class="card-body bg-light">
                                            <h5 class="text-success">{{ number_format($monthlyEarnings, 2) }} PKR</h5>
                                        </div>
                                    </div>
                                </div>
                            @endcan

                            @can('export earning')
                            <div class="row mt-4">
    <div class="col-md-12 mb-3 d-flex justify-content-end">
        <form action="{{ route('bills.exportLastMonth') }}" method="POST">
            @csrf
            <button class="btn btn-success">
                Export Last Month's Data
            </button>
        </form>
    </div>
</div>
@endcan


                            @if(isset($totalPaidAmount))
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="alert alert-info">
                <strong>Total Paid Amount:</strong> {{ number_format($totalPaidAmount, 2) }} PKR
            </div>
        </div>
    </div>
@endif

                            <!-- Monthly Paid Earnings -->

                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="row mt-4">
    <div class="col-md-12 mb-3">
        <!-- General Search -->
        <form action="{{ route('bills.index') }}" method="GET" class="search-bar">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by customer, status, payment method, or unique ID..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Date Range Search -->
<div class="row mt-4">
    <div class="col-md-12 mb-3">
        <form action="{{ route('bills.index') }}" method="GET" class="search-bar">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('bills.index') }}" class="btn btn-secondary w-100 mt-2">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>


                    <!-- Bills Table -->
                    <div class="col-md-12">
                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique ID</th>
                                        <th>Customer</th>
                                        <th>Total Price</th>
                                        <th>Paid Amount</th>
                                        <th>Remaining Balance</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bills as $bill)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bill->unique_id }}</td>
                                            <td>{{ $bill->customer_name }}</td>
                                            <td>{{ number_format($bill->total_price, 2) }} PKR</td>
                                            <td>{{ number_format($bill->paid_amount, 2) }} PKR</td>
                                            <td>{{ number_format($bill->remaining_balance, 2) }} PKR</td>
                                            <td>
                                                <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : 'danger' }} fs-5">
                                                    {{ ucfirst($bill->status) }}
                                                </span>
                                            </td>

                                            <td>{{ ucfirst($bill->payment_method) }}</td>
                                            <td>{{ $bill->created_at->format('d-m-Y') }}</td>
                                            <td>
                                            @if($bill->status === 'pending')
        <form action="{{ route('bills.markAsPaid', $bill->id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">
                Mark as Paid
            </button>
        </form>
    @endif

                                                <a href="{{ route('bills.showDetails', $bill->id) }}" class="btn btn-sm btn-info">
                                                View
                                            </a>

                                                <button class="btn btn-danger refund-btn" onclick="window.location.href='{{ route('bills.refund', $bill->id) }}'">
                                                    Refund
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $bills->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>






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
