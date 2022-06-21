<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>

    <p>You have selected {{ $first_name }} {{ $last_name }} as your {{ $contact_status }} contact to ensure your well being. Please confirm or deny by clicking here.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $deny_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; cursor: pointer;">DENY</button></a>
        </div>
        <div class="">
            <a href="{{ $confirm_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">CONFIRM</button></a>
        </div>
    </div>

    <p>Thank You</p>
    <p>bETERNAL</p>
</body>

</html>