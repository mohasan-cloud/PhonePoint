<!DOCTYPE html>
<html>
<head>
    <title>Last Month's Bills</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Last Month's Bills</h1>
    <table>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bill->unique_id }}</td>
                    <td>{{ $bill->customer_name }}</td>
                    <td>{{ number_format($bill->total_price, 2) }} PKR</td>
                    <td>{{ number_format($bill->paid_amount, 2) }} PKR</td>
                    <td>{{ number_format($bill->remaining_balance, 2) }} PKR</td>
                    <td>{{ ucfirst($bill->status) }}</td>
                    <td>{{ ucfirst($bill->payment_method) }}</td>
                    <td>{{ $bill->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
