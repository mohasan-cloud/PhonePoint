<x-admin-layout>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="text-primary mb-0">Bill Details</h4>
                    </div>
                    <div class="card-body">
                        <h5><strong>Customer Name:</strong> {{ $bill->customer_name }}</h5>
                        <p><strong>Total Price:</strong> {{ number_format($bill->total_price, 2) }} PKR</p>
                        <p><strong>Paid Amount:</strong> {{ number_format($bill->paid_amount, 2) }} PKR</p>
                        <p><strong>Remaining Balance:</strong> {{ number_format($bill->remaining_balance, 2) }} PKR</p>
                        <p><strong>Status:</strong> {{ ucfirst($bill->status) }}</p>
                        <p><strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}</p>
                        <p><strong>Date:</strong> {{ $bill->created_at->format('d-m-Y') }}</p>
                        
                        <h5 class="mt-4"><strong>Discount Details:</strong></h5>
                        @php
                            $discountDetails = json_decode($bill->discount_details, true);
                        @endphp
                        @if(!empty($discountDetails['total_discount']) && $discountDetails['total_discount'] != 0)
                            <p><strong>Total Discount:</strong> {{ $discountDetails['total_discount'] }}%</p>
                        @endif
                        <p><strong>Total Amount:</strong> {{ number_format($discountDetails['total_amount'] ?? 0, 2) }} PKR</p>
                        @if(!empty($discountDetails['total_amount_after_discount']) && $discountDetails['total_amount_after_discount'] != 0)
                        <p><strong>Total Amount After Discount:</strong> {{ number_format($discountDetails['total_amount_after_discount'] ?? 0, 2) }} PKR</p>
                        @endif


                        <h5 class="mt-4"><strong>Products:</strong></h5>
                        <ul class="list-group">
                            @foreach ($products as $product)
                                <li class="list-group-item">
                                    <strong>{{ $product['name'] }}</strong> (Quantity: {{ $product['quantity'] }})
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('bills.index') }}" class="btn btn-secondary mt-4">Back to Bills</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
