<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ $recipient_name }} {{ $recipient_last_name }}</p>

    <p>You have received legacy from {{ $user_name }} {{ $user_last_name }}.</p>
    <p>In order to view the media please click on the following Link.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $legacy_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px; background-color: #F7DB02; border-style: none; margin-left:10px;">OPEN</button></a>
        </div>
    </div>

    <p>Thank You</p>
    <p>bETERNAL</p>
</body>

</html>