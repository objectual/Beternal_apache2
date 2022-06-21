<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ $first_name }} {{ $last_name }}</p>

    <p>I have selected you as a contact to ensure my well being and secure and distribute my legacy. Please confirm or deny your acceptance by clicking here.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $deny_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; cursor: pointer;">DENY</button></a>
        </div>
        <div class="">
            <a href="{{ $confirm_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">CONFIRM</button></a>
        </div>
    </div>

    <p>Thank You</p>
    <p>{{ $user_first_name }} {{ $user_last_name }}</p>
</body>

</html>