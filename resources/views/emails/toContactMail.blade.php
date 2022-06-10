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

    <div style="display:flex;">
        <div class="">
            <a href="http://167.99.0.236/"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; cursor: pointer;">DENY</button></a>
        </div>
        <div class="">
            @if($action_url == 0)
            <a href="http://167.99.0.236/register"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">CONFIRM</button></a>
            @else
            <a href="http://167.99.0.236/login"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">CONFIRM</button></a>
            @endif
        </div>
    </div>
</body>

</html>