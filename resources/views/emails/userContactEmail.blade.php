<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>{{ $contact_name }}, is {{ $user_name }} ok? We have not heard from them lately.</p>
    <p>Please reply with the status of {{ $user_name }} by selecting one of the two choices below.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $status_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; cursor: pointer;">Alive</button></a>
        </div>
        <div class="">
            <a href="{{ $distribution_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">Deceased</button></a>
        </div>
    </div>

    <p>Thank You,</p>
    <p>bETERNAL Team</p>
    <p>beternal.life</p>
    <p>Your Legacy. Your Way.</p>
</body>

</html>