<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            background-color: #f0f8ff;
            color: #333;
            padding: 10px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #b0c4de;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #0073e6;
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

        .button {
            display: inline-block;
            background-color: #0073e6;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>✅ Feedback Submission Confirmation</h2>
        <p>Dear {{ $feedback->name }},</p>
        <p>Thank you for submitting your valuable feedback. Here are the details of your submission:</p>
        <p><strong>Product ID:</strong> {{ $feedback->product_id }}</p>
        <p><strong>Rating:</strong> ⭐ {{ $feedback->rating }} / 5</p>
        <p><strong>Comment:</strong> "{{ $feedback->comment }}"</p>
        <p>We truly appreciate your input and are always striving to improve based on your feedback!</p>
        <a href="#" class="button">Visit Our Website</a>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name</p>
        </div>
    </div>
</body>
</html>
