<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <h1>Welcome. You are registered.</h1>
    <p>Dear {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>

    <p>Thank you</p>
    <p>bETERNAL Team</p>
</body>

</html>