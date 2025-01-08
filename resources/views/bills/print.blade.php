<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header, .footer {
            text-align: center;
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f1f1f1;
        }
        .footer {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bill Receipt</h1>
        <p>Date: {{ $bill->created_at->format('d-m-Y') }}</p>
    </div>

    <div class="details">
        <p><strong>Customer:</strong> {{ $bill->customer_name }}</p>
        <p><strong>Total Price:</strong> {{ number_format($bill->total_price, 2) }} PKR</p>
        <p><strong>Paid Amount:</strong> {{ number_format($bill->paid_amount, 2) }} PKR</p>
        <p><strong>Remaining Balance:</strong> {{ number_format($bill->remaining_balance, 2) }} PKR</p>

        <!-- Display discount if available -->
        @if($bill->discount)
            <p><strong>Discount:</strong> {{ number_format($bill->discount, 2) }} PKR</p>
        @endif

        <!-- Display discount details -->
        @if($bill->discount)
       
        @if($bill->discount_details)
            @php
                $discountDetails = json_decode($bill->discount_details, true);
            @endphp
            @if($discountDetails)
                <p><strong>Discount Details:</strong></p>
                <ul>
                    <li><strong>Total Discount:</strong> {{ number_format($discountDetails['total_discount'], 2) }} PKR</li>
                    <li><strong>Total Amount:</strong> {{ number_format($discountDetails['total_amount'], 2) }} PKR</li>
                    <li><strong>Total Amount After Discount:</strong> {{ number_format($discountDetails['total_amount_after_discount'], 2) }} PKR</li>
                </ul>
            @endif
        @endif
        @endif
    </div>

    <h3>Products</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = json_decode($bill->products, true);  // Decode the products data from JSON
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ number_format($product['price'], 2) }} PKR</td>
                    <td>{{ number_format($product['quantity'] * $product['price'], 2) }} PKR</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
