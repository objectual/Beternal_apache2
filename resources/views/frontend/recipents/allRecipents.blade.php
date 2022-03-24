@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")

<div class="container-fluid bg-create scroll-height-mobile mobile-padding recipent-padding-bottom">
    <div class="col-md-10 m-auto">
        <div class="scroll-div">
            <div class="row">
                <div class="row p-3 col-12 padding-recipent">
                    <div class="col-md-2">
                        <h5 class="cl-white filter-heading">FILTER BY:</h5>
                    </div>
                    <div class="col-md-4 mb-2 padding-right-mobile-rec">
                        <div class="">
                            <div class="input-group">
                                <input type="text" id="name" class="form-control search-input" placeholder="Search by Recipient's Name">
                                <div class="input-group-append">
                                    <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" onclick="recipentByName()" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <select class="form-select padding-custom" id="user_group" required>
                            <option selected value="">Group</option>
                            @if(isset($groups))
                            @foreach($groups as $key => $group)
                            <option value="{{ $group->id }}">{{ $group->group_title }}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <select class="form-select padding-custom" id="user_contact" required>
                            <option selected value="">Status</option>
                            @if(isset($contact_status))
                            @foreach($contact_status as $key => $contact)
                            <option value="{{ $contact->id }}">{{ $contact->contact_title }}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <button class="select-recipent-btn" onclick="filterRecipent()">Search</button>
                    </div>
                </div>
            </div>
            <div class="row select-recipent-bottom-padding" id="show_recipents">
                <div class="col-lg-2 col-4 text-center">
                    <a href="recipents/add-form" class="">
                        <img class="recipent-img" src="{{ asset('public/assets/images/add.svg')}}" />
                        <p class="sel-text color-primary mt-3">Add </p>
                    </a>
                </div>
                @if(isset($user_recipents))
                @foreach($user_recipents as $key => $recipent)
                <div class="col-lg-2 text-center col-4 position-relative">
                    <img class="recipent-img" src="{{ asset($recipent->profile_image) }}" />
                    <p class="cl-white sel-text mt-3">{{ $recipent->name }} {{ $recipent->last_name }}</p>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

</div>

@endsection

<script type="text/javascript">
    function recipentByName() {
        var recipent_name = document.getElementById('name').value;
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');

        if (obj != null) {
            len = obj.length;
        }
        if (recipent_name != '') {
            recipent_name = recipent_name.toLowerCase();
            $('#show_recipents').empty();
        }
        if (len > 0) {
            var add_new = '<div class="col-lg-2 col-4 text-center"><a href="recipents/add-form" class=""><img class="recipent-img" src="public/assets/images/add.svg" /><p class="sel-text color-primary mt-3">Add </p></a></div>';
            $("#show_recipents").append(add_new);
            for (var i = 0; i < len; i++) {
                var name = obj[i].name;
                var last_name = obj[i].last_name;
                name = name.toLowerCase();
                last_name = last_name.toLowerCase();
                if(recipent_name == name || recipent_name == last_name) {
                    var profile_image = obj[i].profile_image;
                    var display_image = profile_image.substring(1);

                    var add_new = '<div class="col-lg-2 col-4 text-center"><a href="recipents/add-form" class=""><img class="recipent-img" src="public/assets/images/add.svg" /><p class="sel-text color-primary mt-3">Add </p></a></div>';

                    var recipent = '<div class="col-lg-2 text-center col-4 position-relative"><img class="recipent-img" src="' + display_image + '" /><p class="cl-white sel-text mt-3">' + name + ' ' + last_name + '</p></div>';

                    $("#show_recipents").append(recipent);
                }
            }
        }
    }

    function filterRecipent() {
        var group_id = document.getElementById('user_group').value;
        var contact_id = document.getElementById('user_contact').value;
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        var add_new = '<div class="col-lg-2 col-4 text-center"><a href="recipents/add-form" class=""><img class="recipent-img" src="public/assets/images/add.svg" /><p class="sel-text color-primary mt-3">Add </p></a></div>';

        if (obj != null) {
            len = obj.length;
        }

        if (group_id != '' && contact_id != '') {
            $('#show_recipents').empty();
            $.ajax({
                url: 'filter-recipent/' + contact_id,
                type: 'get',
                success: function(response) {
                    var len = 0;
                    $("#show_recipents").append(add_new);
                    if (response != null) {
                        len = response.length;
                    }
                    if (len > 0) {
                        if(group_id == response[0].group_id) {
                            var name = response[0].name;
                            var last_name = response[0].last_name;
                            var profile_image = response[0].profile_image;
                            var display_image = profile_image.substring(1);
                            var recipent = '<div class="col-lg-2 text-center col-4 position-relative"><img class="recipent-img" src="' + display_image + '" /><p class="cl-white sel-text mt-3">' + name + ' ' + last_name + '</p></div>';
                            $("#show_recipents").append(recipent);
                        }
                    }
                }
            });
        }
        else if (contact_id != '') {
            $('#show_recipents').empty();
            $.ajax({
                url: 'filter-recipent/' + contact_id,
                type: 'get',
                success: function(response) {
                    var len = 0;
                    $("#show_recipents").append(add_new);
                    if (response != null) {
                        len = response.length;
                    }
                    if (len > 0) {
                        var name = response[0].name;
                        var last_name = response[0].last_name;
                        var profile_image = response[0].profile_image;
                        var display_image = profile_image.substring(1);
                        var recipent = '<div class="col-lg-2 text-center col-4 position-relative"><img class="recipent-img" src="' + display_image + '" /><p class="cl-white sel-text mt-3">' + name + ' ' + last_name + '</p></div>';
                        $("#show_recipents").append(recipent);
                    }
                }
            });
        }
        else if (group_id != '') {
            $('#show_recipents').empty();
            if (len > 0) {
                $("#show_recipents").append(add_new);
                for (var i = 0; i < len; i++) {
                    if(group_id == obj[i].group_id) {
                        var name = obj[i].name;
                        var last_name = obj[i].last_name;
                        var profile_image = obj[i].profile_image;
                        var display_image = profile_image.substring(1);
                        var recipent = '<div class="col-lg-2 text-center col-4 position-relative"><img class="recipent-img" src="' + display_image + '" /><p class="cl-white sel-text mt-3">' + name + ' ' + last_name + '</p></div>';
                        $("#show_recipents").append(recipent);
                    }
                }
            }
        }
        else if (group_id == '') {
            $('#show_recipents').empty();
            if (len > 0) {
                $("#show_recipents").append(add_new);
                for (var i = 0; i < len; i++) {
                    
                        var name = obj[i].name;
                        var last_name = obj[i].last_name;
                        var profile_image = obj[i].profile_image;
                        var display_image = profile_image.substring(1);
                        var recipent = '<div class="col-lg-2 text-center col-4 position-relative"><img class="recipent-img" src="' + display_image + '" /><p class="cl-white sel-text mt-3">' + name + ' ' + last_name + '</p></div>';
                        $("#show_recipents").append(recipent);
                    
                }
            }
        }
    }
</script>