

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
                                <h1 class="text-primary mb-0"> Shops Bills Overview</h1>
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
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="row mt-4">
                        <div class="col-md-12 mb-3">
                            <form action="{{ route('shop.bills.index') }}" method="GET" class="search-bar">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by customer, status, or method..." value="{{ request('search') }}">
                                    <button class="btn btn-primary">Search</button>
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
                                        <th>Shop Id</th>
                                        <th>Shop Name</th>
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
                                            <td>{{ $bill->customer_shop_id }}</td>
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
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#billDetailsModal" onclick="showBillDetails({{ $bill->id }})">
                                                    View
                                                </button>
                                                <button class="btn btn-danger refund-btn" onclick="window.location.href='{{ route('shop.bills.refund', $bill->id) }}'">
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




        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Process Return</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="returnForm">
                            <div class="form-group">
                                <label for="unique_id">Unique ID</label>
                                <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Enter Bill Unique ID" required>
                            </div>
                            <div class="form-group">
                                <label for="refund_amount">Refund Amount</label>
                                <input type="text" class="form-control" id="refund_amount" name="refund_amount" readonly>
                            </div>
                            <!-- Other refund-related fields can go here -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="processReturnBtn">Process Return</button>
                    </div>
                </div>
            </div>
        </div>



<!-- Modal for Bill Details -->
<div class="modal fade" id="billDetailsModal" tabindex="-1" aria-labelledby="billDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="billDetailsModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" id="billDetailsContent">
                <!-- Loading Spinner -->
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
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



<script>
    function showBillDetails(billId) {
        const modalContent = document.getElementById('billDetailsContent');

        // Show loading spinner
        modalContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        // Fetch bill details
        fetch(`/bills/${billId}/shop`)
            .then(response => response.json())
            .then(data => {
                modalContent.innerHTML = `
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Customer Name:</strong> ${data.customer_name}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Price:</strong> ${data.total_price} PKR</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Paid Amount:</strong> ${data.paid_amount} PKR</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Remaining Balance:</strong> ${data.remaining_balance} PKR</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Payment Method:</strong> ${data.payment_method}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> ${data.status}</p>
                            </div>
                             <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Unique ID:</strong> ${data.unique_id}</p> <!-- Add unique ID -->
                    </div>
                </div>
                        </div>
                        <hr>
                        <h5 class="mb-3">Products</h5>
                    <ul class="list-group">
                        ${data.products.map(product => `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${product.name}
                                <span class="badge bg-secondary" style="font-size: 1rem; padding: 0.5rem 1rem;">${product.quantity}</span>
                            </li>
                        `).join('')}
                    </ul>
                    </div>
                `;
            })
            .catch(error => {
                modalContent.innerHTML = '<p class="text-danger text-center">Failed to load details.</p>';
                console.error(error);
            });
    }
</script>

</x-admin-layout>
