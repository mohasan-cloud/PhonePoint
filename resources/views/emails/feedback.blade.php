<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            padding: 10px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #0056b3;
        }

        p {
            margin: 8px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🚀 New Feedback Submitted</h2>
        <p><strong>Name:</strong> {{ $feedback->name }}</p>
        <p><strong>Email:</strong> {{ $feedback->email }}</p>
        <p><strong>Product ID:</strong> {{ $feedback->product_id }}</p>
        <p><strong>Rating:</strong> ⭐ {{ $feedback->rating }} / 5</p>
        <p><strong>Comment:</strong> {{ $feedback->comment }}</p>
        <div class="footer">
            <p>Thank you for your attention to this feedback.</p>
            <p>&copy; {{ date('Y') }} Your Company Name</p>
        </div>
    </div>
</body>
</html>
