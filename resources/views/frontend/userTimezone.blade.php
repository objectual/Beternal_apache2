@extends("frontend.layouts.layout")
@section("title","Timezone")
@section("content")
@php $base_url = url(''); $is_ios = 0; @endphp

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyBTlqtwrPryWwrJaqPA2yWC8ysIHRi9GfM",
        authDomain: "beternal-notification.firebaseapp.com",
        projectId: "beternal-notification",
        storageBucket: "beternal-notification.appspot.com",
        messagingSenderId: "523114589887",
        appId: "1:523114589887:web:b2a6ae97d7c80cdc5fe00a",
        measurementId: "G-LHVK7PR2P0"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
</script>

@if((new \Jenssegers\Agent\Agent())->isiOS())
    @php $is_ios = 1; @endphp
@endif

<body onload="setTimezone(this)"></body>
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">Please Wait..</p>
                </div>
            </div>
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
        var is_ios = '<?= $is_ios ?>';

        if (is_ios == 1) {
            $.ajax({
                url: base_url + '/set-timezone/' + user_timezone,
                type: 'get',
                success: function(response) {
                    if (response == 'success') {
                        location.reload();
                    }
                }
            });
        } else {
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