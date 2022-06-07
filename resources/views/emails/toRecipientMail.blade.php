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

    <div class="row pt-3 pb-5 media-icons">
        <div class="col-lg-2">
            <a href="http://167.99.0.236/"><button class="filter-btn btn w-100 text-center py-2">DENY</button></a>
        </div>
        <div class="col-lg-2">
            <a href="http://167.99.0.236/"><button class="filter-btn btn w-100 text-center py-2">CONFIRM</button></a>
        </div>
    </div>
</body>

</html>