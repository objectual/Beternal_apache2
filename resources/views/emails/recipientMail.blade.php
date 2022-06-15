<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>

    <p>You have selected {{ $first_name }} {{ $last_name }} as your Recipient.</p>

    <p>Thank You</p>
    <p>bETERNAL</p>

    <!-- <div style="display:flex;">
        <div class="">
            <a href="http://167.99.0.236/recipents"><button style="color: #000; border-radius: 5px; padding: 9px 55px;    background-color: #F7DB02; border-style: none; margin-left:10px;">CHECK</button></a>
        </div>
    </div> -->
</body>

</html>