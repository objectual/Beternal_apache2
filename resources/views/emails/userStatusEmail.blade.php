<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ $first_name }}</p>

    <p>We have not heard from you and want to confirm that you are OK.</p>
    <p>Please respond with your confirmation by selecting the button below.</p>

    <div style="display:flex;">
        <div class="">
            <a href="{{ $status_url }}"><button style="color: #000; border-radius: 5px; padding: 9px 55px; background-color: #F7DB02; border-style: none; margin-left:10px;">All Good</button></a>
        </div>
    </div>

    <p>Thank You</p>
    <p>bETERNAL</p>
</body>

</html>