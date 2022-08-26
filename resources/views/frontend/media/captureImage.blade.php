@extends("frontend.layouts.layout")
@section("title","Capture Image")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div h-auto">
        <form method="POST" action="{{ route('user.media.upload-media') }}" id="main_form" enctype="multipart/form-data" onsubmit="return validateForm(this)">
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
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ route('user.media.my-media') }}">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/view-gallery.png') }}" class="view-gallery-img">
                                </div>
                                <span class="record-images" style="color: #F7DB02;">&nbsp;&nbsp;View Gallery</span>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center" id="attachment">
                            <label for="file">
                                <picture class="tv_image">
                                    <img src="" id="ban_image" type="image" height="500" width="600" />
                                </picture>
                            </label>
                        </div>
                    </div>

                    <script>
                        document.getElementById("attachment").style.display = "none";
                        var loadFile = function(event) {
                            document.getElementById("attachment").style.display = "block";
                            var image = document.getElementById('ban_image');
                            image.src = URL.createObjectURL(event.target.files[0]);
                        };
                    </script>
                    
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
                            <button class="btn upg-add-img-btn w-100" id="first_form">Add To My Media</button>
                        </div>
                    </div>
                    <div class="row pt-4 mb-4">
                        <div class="col-12 ">
                            <a class="btn upg-add-img-btn w-100" onclick="uploadType(this)">Add To My Media</a>
                        </div>
                    </div>
                    <div class="row pt-4 mb-4">
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
                <div>
                <button type="button" class="close close-select-media" data-dismiss="myMedia" onclick="closeMedia()">&times;</button>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
                <form class="mt-5" method="POST" action="{{ route('user.media.store-media') }}" id="modal_form" enctype="multipart/form-data" onsubmit="return validateForm(this)">
                    @csrf
                    <input type="hidden" id="media_type" name="media_type" value="photo">
                    <input type="hidden" id="upload_type_2" name="upload_type_2" value="">
                    <div class="container-fluid pb-4 h-auto upgrade-back mt-2">
                        <div class="scroll-div h-auto">
                            <div class="row" id="open_camera">
                                <div class="col-md-12 mt-2">
                                    <div id="my_camera"></div>
                                    <input type=button value="Take Snapshot" class="mt-2" onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                </div>
                            </div>
                            <div class="row" id="display_photo">
                                <div class="col-md-12 mt-2">
                                    <div id="results"></div>
                                    <input type="button" value="Take New Snapshot" class="mt-2" id="new_photo" onClick="take_new_snapshot()">
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
                                    <div class="row pt-4" style="display: none;">
                                        <div class="col-12">
                                            <button class="btn upg-add-img-btn w-100" id="downloadButton" data-url="{{route('user.media.store-media')}}">Add To My Media</button>
                                        </div>
                                    </div>
                                    <div class="row pt-4">
                                        <div class="col-12 ">
                                            <a class="btn upg-add-img-btn w-100" onclick="uploadTypeRecording(this)">Add To My Media</a>
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
                        width: 600,
                        height: 400,
                        image_format: 'jpeg',
                        jpeg_quality: 90
                    });

                    Webcam.attach('#my_camera');

                    document.getElementById("new_photo").style.display = "none";

                    function take_snapshot() {
                        Webcam.snap(function(data_uri) {
                            $(".image-tag").val(data_uri);
                            document.getElementById("display_photo").style.display = "block";
                            document.getElementById("new_photo").style.display = "block";
                            document.getElementById("open_camera").style.display = "none";
                            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                        });
                    }

                    function take_new_snapshot() {
                        document.getElementById("display_photo").style.display = "none";
                        document.getElementById("open_camera").style.display = "block";
                    }
                </script>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectTypeRecording" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 text-center offset-lg-3">
                            <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/audio (2).png') }}" />
                        </div>
                    </div>
                    <div class="row pt-3 pb-5 media-icons">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-3">
                            <button class="filter-btn btn w-100 text-center py-2 mb-3" onclick="addMediaRecording('media')">Add To Schedule</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="filter-btn btn w-100 text-center py-2 mb-3" onclick="addMediaRecording('legacy')">Add To Legacy</button>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loaderUpload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog logout-modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-10 text-center offset-lg-1">
                            <img style="height:60px; width:60px;" src="{{ asset('/public/assets/images/loader.gif')}}" /> 
                            <p class="text-white">Please Wait</p>
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
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/camera.png') }}" />
                    </div>
                </div>
                <div class="row pt-3 pb-5 media-icons">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2 mb-3" onclick="addToMedia(this)">Add To Schedule</button>
                    </div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2 mb-3" onclick="addToLegacy(this)">Add To Legacy</button>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog logout-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-10 text-center offset-lg-1">
                        <img style="height:60px; width:60px;" src="{{ asset('/public/assets/images/loader.gif')}}" />
                        <p class="text-white">Please Wait</p>
                    </div>
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

    function closeMedia() {
        $("#captureImage").modal("hide");
    }

    function uploadTypeRecording() {
        selectTypeRecording.style.display = "block";
        $("#selectTypeRecording").modal("show");
    }

    function addMediaRecording(current) {
        var selectTypeRecording = document.getElementById('selectTypeRecording');
        var upload_type = document.getElementById('upload_type_2');
        upload_type.value = current;
        selectTypeRecording.style.display = "none";
        $("#downloadButton").click()
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
            var upload_loader = $('#loader');
        }
        if (current.id == 'modal_form') {
            var title_id = 'title_2';
            var description_id = 'description_2'
            var title_msg = $('#show_title_msg_2');
            var description_msg = $('#show_description_msg_2');
            var show_msg = $('#show_msg_2');
            var upload_loader = $('#loaderUpload');
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
            upload_loader.modal("show");
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