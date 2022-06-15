<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ $first_name }} {{ $last_name }}</p>

    <p>{{ $recipient_first_name }} {{ $recipient_last_name }} has accepted your assignment as {{ $contact_title }}.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $confirm_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">OK</button></a>
        </div>
    </div>

    <p>Thank You</p>
    <p>bETERNAL</p>
</body>

</html>