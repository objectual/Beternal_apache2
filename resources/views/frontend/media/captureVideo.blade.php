@extends("frontend.layouts.layout")
@section("title","Capture Video")
@section("content")
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div">
        <form method="POST" action="{{ route('user.medias.upload-video') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 mt-4">
                    <div class="d-flex mt-4">
                        <div class="col-md-4 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                                <div class="pb-3">
                                    <img src="{{ asset('/public/assets/images/video.svg') }}" class="record-video">
                                </div>
                                <span class="d-block" style="color: #ffaa00;">&nbsp;&nbsp;Record Video</span>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a>
                                <div class="pb-3">
                                    <img src="{{ asset('/public/assets/images/device-gallery.svg') }}" class="gallery-img">
                                </div>
                                <!-- <span class="icon-upload" style="color: #ffaa00;">&nbsp;&nbsp;Device Gallery</span> -->

                                @if($errors->has('image'))
                                <div class="error">{{ $errors->first('file_name') }}</div>
                                @endif
                                <label style="color: #ffaa00;" for="file">&nbsp;&nbsp;Device Gallery</label>
                                <input type="file" accept="video/*" name="file_name" id="file" style="display: none;">
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ route('user.medias.my-media') }}">
                                <div class="pb-3">
                                    <img src="{{ asset('/public/assets/images/view-gallery.svg') }}" class="view-gallery-img">
                                </div>
                                <span class="" style="color: #ffaa00;">&nbsp;&nbsp;View Gallery</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="mb-3 w-100">
                            <label for="exampleInputEmail1" class="form-label text-white">Video Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control capture-form" placeholder="Video Title Here" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label for="exampleInputPassword1" class="form-label  text-white">Description</label>
                            <textarea class="form-control capture-form" name="description" placeholder="Description Here" required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <!-- <div class="row m-0 mb-3">
                        <div class="col-lg-2 p-0 col-4 text-white">Date:</div>
                        <div class="col-lg-7 col-2"></div>
                        <div class="col-lg-3 col-6 text-white text-end p-0">22/11/2021</div>
                    </div> -->
                    <div class="row">
                        <div class="mb-3 w-100">
                            <div class="">
                                <div class="input-group">
                                    <input type="text" id="name" class="form-control search-input" placeholder="Search by Recipient's Name">
                                    <div class="input-group-append">
                                        <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" onclick="recipentByName()" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white">Assign Recipient</p>
                        <div class="row mb-3" id="show_recipents">
                            @if(isset($user_recipents))
                            <div class="col-lg-2 col-3 rec-images">
                                <img src="{{ asset('public/media/image/all-users.png') }}">
                                <p class="cl-white sel-text mt-3">
                                    <input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all recipient" onclick="selectAllRecipient(this)">
                                    All
                                </p>
                            </div>
                            @foreach($user_recipents as $key => $recipent)
                            <div class="col-lg-2 col-3 rec-images">
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
                                    <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" onclick="groupByName()" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-white">Select Group</p>
                    <div id="show_groups">
                        @if(isset($groups))
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
                    <p class="text-white mt-2">Select Type</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="media_type" value="share" required>
                        <label class="form-check-label text-white" for="group_id">Share Media</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="media_type" value="legacy" required>
                        <label class="form-check-label text-white" for="group_id">Legacy</label>
                    </div>
                    <!-- <div class="row pt-4">
                        <div class="col-12 ">
                            <button data-bs-toggle="modal" data-bs-target="#redirectModal" class="btn upg-add-img-btn w-100">Save Your Memory</button>
                        </div>
                        <div class="col-12 mt-3 ">
                            <a href="./delivery.html" class="btn upg-select-del-btn w-100">Select Delivery</a>
                        </div>
                    </div> -->
                    <div class="row pt-4">
                        <div class="col-12 ">
                            <button class="btn upg-add-img-btn w-100">Save Your Memory</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade" id="captureImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 text-center offset-lg-3">
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/video-pop.png') }}" />
                        <p>
                            To Record Video, bETERNAL needs permission to access Camera & Microphone
                        </p>
                        <div class="text-center mb-4">
                            <a href="#" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                            <a href="#" class="mx-1" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
                        </div>
                    </div>
                </div>
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
                        <p>
                            We have received your memory, which has been added to Your Legacy.
                        </p>
                        <!-- <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6">
                                <a href="./schedule-media.html" class="btn upg-select-del-btn w-100">Scheduled Media</a>
                            </div>
                            <div class="col-lg-6">
                               <a href="./legacy.html" class="btn upg-select-del-btn w-100">Legacy</a>
                            </div>                           
                         </div> -->
                        <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6 offset-lg-3">
                                <a href="./legacy.html" class="btn upg-select-del-btn w-100">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    function recipentByName() {
        var recipent_name = document.getElementById('name').value;
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        var base_path = 'http://localhost/love-kumar/beternal/Beternal_apache2';

        if (obj != null) {
            len = obj.length;
        }
        if (recipent_name != '') {
            recipent_name = recipent_name.toLowerCase();
            $('#show_recipents').empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var name = obj[i].name;
                    name = name.toLowerCase();
                    if (recipent_name == name) {
                        var recipient_id = obj[i].recipient_id;
                        var profile_image = obj[i].profile_image;

                        var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="' + recipient_id + '"> ' + name + '</p></div>';

                        $("#show_recipents").append(recipent);
                    }
                }
            }
        } else {
            var all_recipient = '<div class="col-lg-2 col-3 rec-images"><img src="' + base_path + '/public/media/image/all-users.png"><p class="cl-white sel-text mt-3"><input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all" onclick="selectAllRecipient(this)"> All</p></div>';
            $('#show_recipents').empty();
            $("#show_recipents").append(all_recipient);

            for (var i = 0; i < len; i++) {
                var name = obj[i].name;
                name = name.toLowerCase();
                var recipient_id = obj[i].recipient_id;
                var profile_image = obj[i].profile_image;

                var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="' + recipient_id + '"> ' + name + '</p></div>';

                $("#show_recipents").append(recipent);
            }
        }
    }

    function selectAllRecipient(current) {
        var inputs = document.querySelectorAll('.user-recipient');
        if(current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if(current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }

    function groupByName() {
        var group_name = document.getElementById('group_name').value;
        var obj = JSON.parse('<?php echo json_encode($groups) ?>');
        var base_path = 'http://localhost/love-kumar/beternal/Beternal_apache2';

        if (obj != null) {
            len = obj.length;
        }
        if (group_name != '') {
            group_name = group_name.toLowerCase();
            $('#show_groups').empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var group_title = obj[i].group_title;
                    group_title = group_title.toLowerCase();
                    if (group_name == group_title) {
                        var id = obj[i].id;
                        group_title = group_title.toUpperCase();
                        var group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="group_id[]" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                        $("#show_groups").append(group);
                    }
                }
            }
        } else {
            var all_group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="all_group" name="all_group" value="all" onclick="selectAllGroup(this)"><label class="form-check-label text-white" for="group_id">All</label></div>';
            $('#show_groups').empty();
            $("#show_groups").append(all_group);

            for (var i = 0; i < len; i++) {
                var group_title = obj[i].group_title;
                var id = obj[i].id;
                group_title = group_title.toUpperCase();
                var group = '<div class="form-check form-check-inline"><input class="form-check-input user-group" type="checkbox" name="group_id[]" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                $("#show_groups").append(group);
            }
        }
    }

    function selectAllGroup(current) {
        var inputs = document.querySelectorAll('.user-group');
        if(current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if(current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }
</script>