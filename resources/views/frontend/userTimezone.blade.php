@extends("frontend.layouts.layout")
@section("title","Timezone")
@section("content")
@php $base_url = url(''); @endphp

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDmlagHFn1yw5KcbXHuIfuuWsw2EcXTmwE",
        authDomain: "notification-test-a3f05.firebaseapp.com",
        databaseURL: 'db-url',
        projectId: "notification-test-a3f05",
        storageBucket: "notification-test-a3f05.appspot.com",
        messagingSenderId: "299026161686",
        appId: "1:299026161686:web:53bf04a964fb438be01537",
        measurementId: "G-RT6CHXQZTF"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
</script>

<body onload="setTimezone(this)"></body>
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">Please Wait..</p>
                </div>
            </div>
            <!-- <div class="row pt-4 mb-4">
                <div class="col-12 ">
                    <a class="btn upg-add-img-btn w-100" onclick="setTimezone(this)">Continue</a>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection

<script>
    function setTimezone() {
        var timezone_offset_minutes = new Date().getTimezoneOffset();
        timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
        var user_timezone = timezone_offset_minutes;
        var base_url = '<?= $base_url ?>';

        $.ajax({
            url: base_url + '/set-timezone/' + user_timezone,
            type: 'get',
            success: function(response) {
                if (response == 'success') {
                    messaging
                        .requestPermission()
                        .then(function() {
                            return messaging.getToken()
                        })
                        .then(function(response) {
                            userDevice(response);
                        }).catch(function(error) {
                            alert(error);
                        });
                }
            }
        });
    }

    function userDevice(device_token) {
        var base_url = '<?= $base_url ?>';
        $.ajax({
            url: base_url + '/device-token/' + device_token,
            type: 'get',
            success: function(response) {
                if (response == 'success') {
                    location.reload();
                }
            }
        });
    }
</script>