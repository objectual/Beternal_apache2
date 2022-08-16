@php $base_url = url(''); @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <button onclick="startFCM()" class="btn btn-danger btn-flat">Allow notification</button>
        </div>
    </div>
</div>
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

    function startFCM() {
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

    function userDevice(device_token) {
        var base_url = '<?= $base_url ?>';
        $.ajax({
            url: base_url + '/device-token/' + device_token,
            type: 'get',
            success: function(response) {
                if (response == 'success') {
                    // location.reload();
                    alert('success');
                } else {
                    alert('issue');
                }
            }
        });
    }
    messaging.onMessage(function(payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>