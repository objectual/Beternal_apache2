@extends("frontend.layouts.layout")
@section("title","Capture Image")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div">
        @if (Session::has('status'))
        <div class="alert alert-success text-center" role="alert">
            {{ Session::get('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('user.medias.upload-media') }}" id="main_form" enctype="multipart/form-data" onsubmit="return validateForm(this)">
            @csrf
            <input type="hidden" id="media_type" name="media_type" value="photo">
            <input type="hidden" id="upload_type" name="upload_type" value="">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 mt-4">
                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-4 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/capture-image.png') }}" class="camera-img">
                                </div>
                                <span class="record-images" style="color: #F7DB02;">&nbsp;&nbsp;Capture Image</span>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a>
                                <div class="pb-3 media-icon-height">
                                    <label class="record-images" style="color: #F7DB02;" for="file"><img src="{{ asset('/public/assets/images/device-gallery.png') }}" class="gallery-img"></label>
                                </div>
                                @if($errors->has('file_name'))
                                <div class="error text-white">
                                    {{ $errors->first('file_name') }}
                                </div>
                                @endif
                                <label class="record-images" style="color: #F7DB02;" for="file">&nbsp;&nbsp;Device Gallery</label>
                                <input type="file" accept="image/*" name="file_name" id="file" style="display: none;" onchange="loadFile(event)">
                            </a>

                            <script>
                                var loadFile = function(event) {
                                    var base_url = '<?= $base_url ?>';
                                    var set_url = base_url+ '/public/assets/images/success-signup.svg';
                                    var msg = '<p class="text-white">Successfully Attached</p><img src="'+ set_url +'" width="50" />';
                                    $('#attachment').empty();
                                    $('#attachment').append(msg);
                                };
                            </script>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ route('user.medias.my-media') }}">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/view-gallery.png') }}" class="view-gallery-img">
                                </div>
                                <span class="record-images" style="color: #F7DB02;">&nbsp;&nbsp;View Gallery</span>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center" id="attachment"></div>
                    </div>
                    
                    <div class="mt-5">
                        <div class="mb-3 w-100">
                            <label for="photo_title" class="form-label text-white">Photo Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control capture-form" placeholder="Photo Title Here" required>
                            <div class="col-12" id="show_title_msg"></div>
                        </div>
                        <div class="mb-3  w-100">
                            <label for="description" class="form-label text-white">Description</label>
                            <textarea class="form-control capture-form" id="description" name="description" placeholder="Description Here" required>{{ old('description') }}</textarea>
                            <div class="col-12" id="show_description_msg"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 w-100">
                            <div class="">
                                <div class="input-group">
                                    <input type="text" id="name" class="form-control search-input" placeholder="Search by Recipient's Name">
                                    <div class="input-group-append">
                                        <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" id="main_serach_by_name" onclick="recipentByName(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white">Assign Recipient</p>
                        <div class="row mb-3" id="show_recipents">
                            @if(isset($user_recipents) && !$user_recipents->isEmpty())
                            <div class="col-lg-2 col-4 rec-images">
                                <img src="{{ asset('public/media/image/all-users.png') }}">
                                <p class="cl-white sel-text mt-3">
                                    <input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all recipient" onclick="selectAllRecipient(this)">
                                    All
                                </p>
                            </div>
                            @foreach($user_recipents as $key => $recipent)
                            <div class="col-lg-2 col-4 rec-images">
                                <img src="{{ asset($recipent->profile_image) }}">
                                <p class="cl-white sel-text mt-3">
                                    <input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="{{ $recipent->recipient_id }}">
                                    {{ $recipent->name }}
                                </p>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <div class="">
                            <div class="input-group">
                                <input type="text" id="group_name" class="form-control search-input" placeholder="Search by Group's Name">
                                <div class="input-group-append">
                                    <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" id="main_serach_by_group" onclick="groupByName(this)" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-white">Select Group</p>
                    <div id="show_groups">
                        @if(isset($groups) && !$groups->isEmpty())
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="all_group" name="all_group" value="all group" onclick="selectAllGroup(this)">
                            <label class="form-check-label text-white" for="group_id">All</label>
                        </div>
                        @foreach($groups as $key => $group)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input user-group" type="checkbox" name="group_id[]" value="{{ $group->id }}">
                            <label class="form-check-label text-white" for="group_id">{{ strtoupper($group->group_title) }}</label>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="row pt-4" id="submit_button" style="display: none;">
                        <div class="col-12 ">
                            <button class="btn upg-add-img-btn w-100" id="first_form">Save Your Memory</button>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12 ">
                            <a class="btn upg-add-img-btn w-100" onclick="uploadType(this)">Save Your Memory</a>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-12" id="show_msg"></div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade record-modal" id="captureImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
                <form method="POST" action="{{ route('user.medias.store-media') }}" id="modal_form" enctype="multipart/form-data" onsubmit="return validateForm(this)">
                    @csrf
                    <input type="hidden" id="media_type" name="media_type" value="photo">
                    <div class="container-fluid pb-4 h-auto upgrade-back mt-2">
                        <div class="scroll-div">
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <div id="my_camera"></div>
                                    <br />
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div id="results">Your captured image will appear here...</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mt-2">
                                        <div class="mb-3 w-100">
                                            <label for="photo_title" class="form-label text-white">Photo Title</label>
                                            <input type="text" id="title_2" name="title_2" value="{{ old('title') }}" class="form-control capture-form" placeholder="Photo Title Here" required>
                                            <div class="col-12" id="show_title_msg_2"></div>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label for="description" class="form-label  text-white">Description</label>
                                            <textarea class="form-control capture-form" id="description_2" name="description_2" placeholder="Description Here" required>{{ old('description') }}</textarea>
                                            <div class="col-12" id="show_description_msg_2"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 w-100">
                                            <div class="">
                                                <div class="input-group">
                                                    <input type="text" id="name_2" class="form-control search-input" placeholder="Search by Recipient's Name">
                                                    <div class="input-group-append">
                                                        <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" id="modal_search_by_name" onclick="recipentByName(this)" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-white">Assign Recipient</p>
                                        <div class="row mb-3" id="show_recipents_2">
                                            @if(isset($user_recipents) && !$user_recipents->isEmpty())
                                            <div class="col-lg-2 col-4 rec-images">
                                                <img src="{{ asset('public/media/image/all-users.png') }}">
                                                <p class="cl-white sel-text mt-3">
                                                    <input class="form-check-input" type="checkbox" id="all_recipient_2" name="all_recipient_2" value="all recipient" onclick="selectAllRecipient(this)">
                                                    All
                                                </p>
                                            </div>
                                            @foreach($user_recipents as $key => $recipent)
                                            <div class="col-lg-2 col-4 rec-images">
                                                <img src="{{ asset($recipent->profile_image) }}">
                                                <p class="cl-white sel-text mt-3">
                                                    <input class="form-check-input user-recipient-2" type="checkbox" name="recipient_id_2[]" value="{{ $recipent->recipient_id }}">
                                                    {{ $recipent->name }}
                                                </p>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3 w-100">
                                        <div class="">
                                            <div class="input-group">
                                                <input type="text" id="group_name_2" class="form-control search-input" placeholder="Search by Group's Name">
                                                <div class="input-group-append">
                                                    <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" id="modal_search_by_group" onclick="groupByName(this)" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-white">Select Group</p>
                                    <div id="show_groups_2">
                                        @if(isset($groups) && !$groups->isEmpty())
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="all_group_2" name="all_group_2" value="all group 2" onclick="selectAllGroup(this)">
                                            <label class="form-check-label text-white" for="group_id">All</label>
                                        </div>
                                        @foreach($groups as $key => $group)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input user-group-2" type="checkbox" name="group_id_2[]" value="{{ $group->id }}">
                                            <label class="form-check-label text-white" for="group_id">{{ strtoupper($group->group_title) }}</label>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12 ">
                                            <button class="btn upg-add-img-btn w-100" id="downloadButton" data-url="{{route('user.medias.store-media')}}">Save Your Memory</button>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12" id="show_msg_2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Configure a few settings and attach camera -->
                <script language="JavaScript">
                    Webcam.set({
                        width: 290,
                        height: 210,
                        image_format: 'jpeg',
                        jpeg_quality: 90
                    });

                    Webcam.attach('#my_camera');

                    function take_snapshot() {
                        Webcam.snap(function(data_uri) {
                            $(".image-tag").val(data_uri);
                            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Redirect Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade" id="redirectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 text-center offset-lg-2">
                        <img class="mt-4 mb-3 audio-pop" src="./images/video-pop.png" />
                        <p>Uploaded successfully.</p>
                        </p>
                        <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6 offset-lg-3">
                                <a href="{{ route('user.medias.capture-image') }}" class="btn upg-select-del-btn w-100">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectType" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 text-center offset-lg-3">
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/audio-pop.png') }}" />
                    </div>
                </div>
                <div class="row pt-3 pb-5 media-icons">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2" onclick="addToMedia(this)">Add To Media</button>
                    </div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2" onclick="addToLegacy(this)">Add To Legacy</button>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    function uploadType() {
        $("#selectType").modal("show");
    }

    function addToMedia() {
        var upload_type = document.getElementById('upload_type');
        upload_type.value = 'media';
        $("#selectType").modal("hide");
        $("#first_form").click()
    }

    function addToLegacy() {
        var upload_type = document.getElementById('upload_type');
        upload_type.value = 'legacy';
        $("#selectType").modal("hide");
        $("#first_form").click()
    }

    function recipentByName(current) {
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        // var base_path = 'http://localhost/love-kumar/beternal/Beternal_apache2';
        var base_path = '<?= $base_url ?>';

        if (obj != null) {
            len = obj.length;
        }
        if (current.id == 'main_serach_by_name') {
            var recipent_name = document.getElementById('name').value;
            var div_recipient = $('#show_recipents');
            var for_recipient_id = 'recipient_id[]';
            var for_all_recipient = 'all_recipient';
        }
        if (current.id == 'modal_search_by_name') {
            var recipent_name = document.getElementById('name_2').value;
            var div_recipient = $('#show_recipents_2');
            var for_recipient_id = 'recipient_id_2[]';
            var for_all_recipient = 'all_recipient_2';
        }

        if (recipent_name != '') {
            recipent_name = recipent_name.toLowerCase();
            div_recipient.empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var name = obj[i].name;
                    name = name.toLowerCase();
                    if (recipent_name == name) {
                        var recipient_id = obj[i].recipient_id;
                        var profile_image = obj[i].profile_image;

                        var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="' + recipient_id + '"> ' + name + '</p></div>';

                        div_recipient.append(recipent);
                    }
                }
            }
        } else {
            var all_recipient = '<div class="col-lg-2 col-3 rec-images"><img src="' + base_path + '/public/media/image/all-users.png"><p class="cl-white sel-text mt-3"><input class="form-check-input" type="checkbox" id="' + for_all_recipient + '" name="' + for_all_recipient + '" value="all" onclick="selectAllRecipient(this)"> All</p></div>';
            div_recipient.empty();
            div_recipient.append(all_recipient);

            for (var i = 0; i < len; i++) {
                var name = obj[i].name;
                name = name.toLowerCase();
                var recipient_id = obj[i].recipient_id;
                var profile_image = obj[i].profile_image;

                var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="' + recipient_id + '"> ' + name + '</p></div>';

                div_recipient.append(recipent);
            }
        }
    }

    function selectAllRecipient(current) {
        if (current.id == 'all_recipient') {
            var inputs = document.querySelectorAll('.user-recipient');
        }
        if (current.id == 'all_recipient_2') {
            var inputs = document.querySelectorAll('.user-recipient-2');
        }
        if (current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if (current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }

    function groupByName(current) {
        var obj = JSON.parse('<?php echo json_encode($groups) ?>');
        // var base_path = 'http://localhost/love-kumar/beternal/Beternal_apache2';
        var base_path = '<?= $base_url ?>';

        if (obj != null) {
            len = obj.length;
        }
        if (current.id == 'main_serach_by_group') {
            var group_name = document.getElementById('group_name').value;
            var div_group = $('#show_groups');
            var for_group_id = 'group_id[]';
            var for_all_group = 'all_group';
        }
        if (current.id == 'modal_search_by_group') {
            var group_name = document.getElementById('group_name_2').value;
            var div_group = $('#show_groups_2');
            var for_group_id = 'group_id_2[]';
            var for_all_group = 'all_group_2';
        }
        if (group_name != '') {
            group_name = group_name.toLowerCase();
            div_group.empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var group_title = obj[i].group_title;
                    group_title = group_title.toLowerCase();
                    if (group_name == group_title) {
                        var id = obj[i].id;
                        group_title = group_title.toUpperCase();
                        var group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="' + for_group_id + '" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                        div_group.append(group);
                    }
                }
            }
        } else {
            var all_group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="' + for_all_group + '" name="' + for_all_group + '" value="all" onclick="selectAllGroup(this)"><label class="form-check-label text-white" for="group_id">All</label></div>';
            div_group.empty();
            div_group.append(all_group);

            for (var i = 0; i < len; i++) {
                var group_title = obj[i].group_title;
                var id = obj[i].id;
                group_title = group_title.toUpperCase();
                var group = '<div class="form-check form-check-inline"><input class="form-check-input user-group" type="checkbox" name="' + for_group_id + '" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                div_group.append(group);
            }
        }
    }

    function selectAllGroup(current) {
        if (current.id == 'all_group') {
            var inputs = document.querySelectorAll('.user-group');
        }
        if (current.id == 'all_group_2') {
            var inputs = document.querySelectorAll('.user-group-2');
        }
        if (current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if (current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }

    function validateForm(current) {
        if (current.id == 'main_form') {
            var title_id = 'title';
            var description_id = 'description'
            var title_msg = $('#show_title_msg');
            var description_msg = $('#show_description_msg');
            var show_msg = $('#show_msg');
        }
        if (current.id == 'modal_form') {
            var title_id = 'title_2';
            var description_id = 'description_2'
            var title_msg = $('#show_title_msg_2');
            var description_msg = $('#show_description_msg_2');
            var show_msg = $('#show_msg_2');
        }
        var title = document.getElementById(title_id).value;
        var description = document.getElementById(description_id).value;
        var plan_details = JSON.parse('<?php echo json_encode($plan_details) ?>');
        var my_media = JSON.parse('<?php echo json_encode($my_media) ?>');
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var msg = '<span class="cl-white">Sorry format not matched! only alphanumeric characters allowed</span>';

        // if (format.test(title)) {
        //     title_msg.empty();
        //     title_msg.append(msg);
        //     return false;
        // }
        // if (format.test(description)) {
        //     title_msg.empty();
        //     description_msg.empty();
        //     description_msg.append(msg);
        //     return false;
        // }
        if (my_media < plan_details[0].photo_limit) {
            return true;
        } else {
            title_msg.empty();
            description_msg.empty();
            show_msg.empty();
            show_msg.append('<span class="cl-white">Sorry your limit for upload video / audio has been fully filled !</span>');
            return false;
        }
    }
</script>