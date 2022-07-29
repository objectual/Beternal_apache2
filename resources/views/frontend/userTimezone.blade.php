@extends("frontend.layouts.layout")
@section("title","Timezone")
@section("content")
@php $base_url = url(''); @endphp
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">We have set your TimeZone</p>
                </div>
            </div>
            <div class="row pt-4 mb-4">
                <div class="col-12 ">
                    <a class="btn upg-add-img-btn w-100" onclick="setTimezone(this)">Continue</a>
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

        $.ajax({
            url: base_url + '/set-timezone/' + user_timezone,
            type: 'get',
            success: function(response) {
                if (response == 'success') {
                    location.reload();
                }
            }
        });
    }
</script>