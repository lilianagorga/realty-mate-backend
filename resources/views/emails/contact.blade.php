<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Contact Message</title>
    </head>
    <body>
    <h1>New Contact Message</h1>
    <p><strong>Name:</strong> {{ $contactData['name'] }}</p>
    <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
    <p><strong>Phone:</strong> {{ $contactData['phone'] }}</p>
    <p><strong>Message:</strong> {{ $contactData['message'] }}</p>
    </body>
</html>
