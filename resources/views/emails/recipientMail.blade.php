<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>

    <p>You have selected {{ $first_name }} {{ $last_name }} as your {{ $contact_status }} contact to ensure your well being.  Please confirm or deny by clicking here.</p>

    <p>Thank you</p>
    <p>bETERNAL Team</p>
</body>

</html>