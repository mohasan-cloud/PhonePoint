<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            font-size: 18px;
        }
        .details {
            margin-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Refund Receipt</h1>
        <p>Bill ID: {{ $bill->id }}</p>
        <p>Refund Processed by: {{ $user->name }}</p>
        <p>Date: {{ now()->toDateString() }}</p>
    </div>

    <div class="details">
        <h3>Refunded Products:</h3>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>Original Quantity</th>
                    <th>Refund Quantity</th>
                    <th>Refund Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productData as $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['barcode'] }}</td>
                        <td>{{ $product['quantity'] + $refundQuantities[$product['barcode']] }}</td>
                        <td>{{ $refundQuantities[$product['barcode']] }}</td>
                        <td>{{ $product['refund_status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer" style="margin-top: 20px;">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
