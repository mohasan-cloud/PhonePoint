<div class="receipt-container">
    <h3>{{ $shop_name }}</h3>
    <p><strong>Bill ID:</strong> {{ $unique_id }}</p>
    <p><strong>Printed By:</strong> {{ $printed_by }}</p>
    <p><strong>Customer Name:</strong> {{ $customer_name }}</p>
    <hr>
    <h4>Products:</h4>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th style="border-bottom: 1px solid #000;">Item</th>
                <th style="border-bottom: 1px solid #000;">Qty</th>
                <th style="border-bottom: 1px solid #000;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['quantity'] }}</td>
                <td>${{ $product['price'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <p><strong>Total Price:</strong> {{ $total_price }}PKR</p>
    <p><strong>Paid Amount:</strong> {{ $paid_amount }}PKR</p>
    <p><strong>Remaining Balance:</strong> {{ $remaining_balance }}PKR</p>
    <p><strong>Status:</strong> {{ ucfirst($status) }}</p>
    <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
    <hr>
    <p><strong>Discount Details:</strong></p>
    <ul>
        <li><strong>Total Discount:</strong> {{ $discount_details['total_discount'] }}%</li>
        <li><strong>Total Amount Before Discount:</strong> {{ $discount_details['total_amount'] }}PKR</li>
        <li><strong>Total Amount After Discount:</strong> {{ $discount_details['total_amount_after_discount'] }}PKR</li>
    </ul>
    <hr>
    <p style="text-align: center; font-style: italic;">Thank you for shopping with us!</p>
</div>

