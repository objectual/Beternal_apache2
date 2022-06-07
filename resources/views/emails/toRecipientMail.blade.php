<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ $first_name }} {{ $last_name }}</p>

    <p>I have selected you as a contact to ensure my well being and secure and distribute my legacy. Please confirm or deny your acceptance by clicking here.</p>

    <p>Thank you</p>
    <p>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
</body>

</html>