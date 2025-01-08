<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Dear {{ $contact->name }},</p>
<p>Thank you for contacting us. Here are the details of your submission:</p>

<ul>
    <li>Name: {{ $contact->name }}</li>
    <li>Email: {{ $contact->email }}</li>
    <li>Phone: {{ $contact->phone }}</li>
    <li>City: {{ $contact->city }}</li>
    <li>Service: {{ $contact->service }}</li>
    <li>Other Service: {{ $contact->other_service }}</li>
    <li>Uni ID: {{ $contact->uni_id }}</li>
    <li>Heard About Us: {{ $contact->heard_about }}</li>
    <li>Message: {{ $contact->messege }}</li>
</ul>
<p>We will get back to you shortly.</p>

</body>
</html>