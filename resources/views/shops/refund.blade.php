<x-admin-layout>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class=" px-4 col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">Refund Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h2 class="mb-4">Refund Bill</h2>
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <h4 class="mb-3">Bill Details</h4>
                                                <p><strong>Bill ID:</strong> {{ $bill->unique_id }}</p>
                                                <p><strong>Customer Name:</strong> {{ $bill->customer_name }}</p>
                                                <p><strong>Total Price:</strong> {{ number_format($bill->total_price, 2) }} PKR</p>
                                                <p><strong>Paid Amount:</strong> {{ number_format($bill->paid_amount, 2) }} PKR</p>
                                                <p><strong>Remaining Balance:</strong> {{ number_format($bill->remaining_balance, 2) }} PKR</p>

                                                <h4 class="mt-4 mb-3">Products</h4>
                                                <form action="{{ route('bills.processRefund', $bill->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="bill_id" value="{{ $bill->id }}">

                                                    <table class="table table-bordered table-striped">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>Refund Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($products as $product)
                                                                <tr>
                                                                    <td>{{ $product['name'] }}</td>
                                                                    <td>{{ $product['quantity'] }}</td>
                                                                    <td>
                                                                        <input type="number" name="refund_quantity[{{ $product['barcode'] }}]"
                                                                            class="form-control" min="0" max="{{ $product['quantity'] }}" value="0">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-lg btn-success mt-4">Process Refund</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
