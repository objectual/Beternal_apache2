<!DOCTYPE html>
<html>

<head>
    <title>Beternal</title>
</head>

<body>
    <p>Dear {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>

    <p>You have selected {{ $first_name }} {{ $last_name }} as your {{ $contact_status }} contact to ensure your well being. Please confirm or deny by clicking here.</p>

    <p>Thank you</p>
    <p>bETERNAL Team</p>

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