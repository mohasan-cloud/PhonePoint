<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>You have been contacted about the following service:</p>

<ul>
    <li>Name: {{ $contact->name }}</li>
    <li>Email: {{ $contact->email }}</li>
    <li>Phone: {{ $contact->phone }}</li>
    <li>City: {{ $contact->city }}</li>
    <li>Service: {{ $contact->service }}</li>
    <li>Uni ID: {{ $contact->uni_id }}</li>
</ul>
<p>Please follow up with the person who contacted you.</p>

</body>
</html>