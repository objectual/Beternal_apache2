@extends("frontend.layouts.layout")
@section("title","Capture Audio")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div h-auto">
        <form method="POST" action="{{ route('user.media.upload-media') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <input type="hidden" id="media_type" name="media_type" value="audio">
            <input type="hidden" id="upload_type" name="upload_type" value="">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 mt-4">
                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-4 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/audio.png') }}" class="record-img">
                                </div>
                                <span class="record-images" style="color: #F7DB02;">&nbsp;&nbsp;Record Audio</span>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a>
                                <div class="pb-3 media-icon-height">
                                    <label class="record-images" style="color: #F7DB02;" for="file"><img src="{{ asset('/public/assets/images/device-gallery.png') }}" class="gallery-img"></label>
                                </div>
                                @if($errors->has('file_name'))
                                <div class="error">{{ $errors->first('file_name') }}</div>
                                @endif
                                <label class="record-images" style="color: #F7DB02;" for="file">&nbsp;&nbsp;Device Gallery</label>
                                <input type="file" accept="audio/*" name="file_name" id="file" style="display: none;" onchange="loadFile(event)">
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

                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-12 text-center" id="attachment">
                            <label for="file">
                                <audio class="tv_audio mt-4" controls></audio>
                            </label>
                        </div>
                    </div>

                    <script>
                        document.getElementById("attachment").style.display = "none";
                        var loadFile = function(event) {
                            document.getElementById("attachment").style.display = "block";
                            var audio_url = URL.createObjectURL(event.target.files[0]);
                            $('.tv_audio').append(
                                '<source src="' + audio_url + '" type="audio/mp3" />'
                            );
                        };
                    </script>

                    <div class="mt-5">
                        <div class="mb-3 w-100">
                            <label for="audio_title" class="form-label text-white">Audio Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control capture-form" placeholder="Audio Title Here" required>
                            <div class="col-12" id="show_title_msg"></div>
                        </div>
                        <div class="mb-3  w-100">
                            <label for="description" class="form-label  text-white">Description</label>
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
                <button type="button" class="close close-select-media" data-dismiss="myMedia" onclick="closeMedia()">&times;</button>
                <meta name="csrf-token" content="{{csrf_token()}}">
                <!-- <div class="row">
                    <div class="col-md-6 mt-5">
                        <h2 class="text-white">Recording / Preview</h2>
                        <audio id="preview" width="160" height="120" autoplay muted></audio>
                        <div class="btn-group mt-4">
                            <div id="startButton" class="start-rec-btn px-3"> Start </div>
                            <div id="stopButton" class="btn btn-danger" style="display:none; margin-left:5px;"> Stop </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5" id="recorded" style="display:none"><br />
                        <audio id="recording" width="160" height="120" controls></audio>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-6 mt-5">
                        <h2 class="text-white">Recording / Preview</h2>
                        <button type="button" class="start-rec-btn px-3" id="record">Start Record</button>
                        <button type="button" class="start-rec-btn px-3" id="stopRecord" disabled>Stop</button>
                    </div>
                    <div class="col-md-6 mt-5" id="recorded"><br />
                        <audio id=recordedAudio></audio>
                    </div>
                </div>

                <div class=" pb-4 mt-2">
                    <div class="scroll-div h-auto">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-2">
                                    <div class="mb-3 w-100">
                                        <label for="audio_title" class="form-label text-white">Audio Title</label>
                                        <input type="text" id="title_2" name="title_2" value="{{ old('title') }}" class="form-control capture-form" placeholder="Audio Title Here">
                                        <div class="col-12" id="show_title_msg_2"></div>
                                    </div>
                                    <div class="mb-3 w-100">
                                        <label for="description" class="form-label  text-white">Description</label>
                                        <textarea class="form-control capture-form" id="description_2" name="description_2" placeholder="Description Here">{{ old('description') }}</textarea>
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
                                        <div class="col-lg-2 col-4 text-center rec-images">
                                            <img src="{{ asset('public/media/image/all-users.png') }}">
                                            <p class="cl-white sel-text mt-3">
                                                <input class="form-check-input" type="checkbox" id="all_recipient_2" name="all_recipient_2" value="all recipient" onclick="selectAllRecipient(this)">
                                                All
                                            </p>
                                        </div>
                                        @foreach($user_recipents as $key => $recipent)
                                        <div class="col-lg-2 col-4 text-center rec-images">
                                            <img src="{{ asset($recipent->profile_image) }}">
                                            <p class="cl-white sel-text mt-3">
                                                <input class="form-check-input user-recipient-2" type="checkbox" name="recipient_id_2[]" value="{{ $recipent->recipient_id }}">
                                                {{ $recipent->name }}
                                            </p>
                                        </div>
                                        @endforeach
                                        @endif
                                        <div class="col-12" id="recipient_msg"></div>
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
                                    <div class="col-12" id="group_msg"></div>
                                </div>
                                <div class="row pt-4" style="display: none;">
                                    <div class="col-12 ">
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

                <script>
                    navigator.mediaDevices.getUserMedia({
                            audio: true
                        })
                        .then(stream => {
                            handlerFunction(stream)
                        })

                    let downloadButton = document.getElementById("downloadButton");
                    var formData = new FormData();

                    function handlerFunction(stream) {
                        rec = new MediaRecorder(stream);
                        rec.ondataavailable = e => {
                            audioChunks.push(e.data);
                            if (rec.state == "inactive") {
                                let blob = new Blob(audioChunks, {
                                    type: 'audio/mp3'
                                });
                                recordedAudio.src = URL.createObjectURL(blob);
                                recordedAudio.controls = true;
                                recordedAudio.autoplay = true;
                                sendData(blob)
                            }
                        }
                    }

                    function sendData(data) {
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        formData.append('file_name', data);
                    }

                    record.onclick = e => {
                        record.disabled = true;
                        record.innerHTML = "recording...";
                        stopRecord.disabled = false;
                        audioChunks = [];
                        rec.start();
                    }
                    stopRecord.onclick = e => {
                        record.disabled = false;
                        stop.disabled = true;
                        record.innerHTML = "Start Record";
                        rec.stop();
                    }

                    if (downloadButton) {
                        downloadButton.addEventListener("click", function() {
                            let media_type = document.getElementById("media_type").value;
                            let upload_type = document.getElementById('upload_type').value;
                            let element = document.getElementById('set_redirect');
                            let title = document.getElementById("title_2").value;
                            let description = document.getElementById("description_2").value;
                            let recipient = document.querySelectorAll('.user-recipient-2');
                            let group = document.querySelectorAll('.user-group-2');
                            let plan_details = JSON.parse('<?php echo json_encode($plan_details) ?>');
                            let my_media = JSON.parse('<?php echo json_encode($my_media) ?>');
                            let format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                            let msg = '<span class="cl-white">Sorry format not matched! only alphanumeric characters allowed</span>';
                            let msg_2 = '<span class="cl-white">Required Field</span>';
                            let msg_recipient = '<span class="cl-white">Please select atleast one recipient!</span>';
                            let msg_group = '<span class="cl-white">Please select atleast one group!</span>';
                            let selected_recipient = 0;
                            let selected_group = 0;
                            if (title == '') {
                                $('#show_title_msg_2').empty();
                                $("#show_title_msg_2").append(msg_2);
                            }
                            if (description == '') {
                                $('#show_description_msg_2').empty();
                                $("#show_description_msg_2").append(msg_2);
                                return false;
                            }
                            if (my_media >= plan_details[0].video_audio_limit) {
                                $('#show_title_msg_2').empty();
                                $('#show_description_msg_2').empty();
                                $('#show_msg_2').empty();
                                $("#show_msg_2").append('<span class="cl-white">Sorry your limit for upload video / audio has been fully filled !</span>');
                                return false;
                            }
                            formData.append('media_type', media_type);
                            formData.append('upload_type', upload_type);
                            formData.append('title', title);
                            formData.append('description', description);
                            for (var i = 0; i < recipient.length; i++) {
                                if (recipient[i].checked == true) {
                                    formData.append('recipient_id[]', recipient[i].value);
                                    selected_recipient = 1;
                                }
                            }
                            for (var i = 0; i < group.length; i++) {
                                if (group[i].checked == true) {
                                    formData.append('group_id[]', group[i].value);
                                    selected_group = 1;
                                }
                            }
                            $("#loaderUpload").modal("show");
                            $.ajax({
                                url: this.getAttribute('data-url'),
                                method: 'POST',
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    if (res.success) {
                                        element.href = res.redirect_url;
                                        $("#loaderUpload").modal("hide");
                                        $("#redirectModal").modal("show");
                                        // location.reload();
                                    }
                                }
                            });
                        }, false);
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

    <div class="modal fade" id="loaderAudio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog logout-modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-10 text-center offset-lg-1">
                            <img style="height:60px; width:60px;" src="{{ asset('/public/assets/images/loader.gif')}}" />
                            <p class="text-white">Loading Audio Please Wait</p>
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
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/audio (1).png') }}" />
                        <p>Uploaded successfully.</p>
                        <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6 offset-lg-3">
                                <a href="" id="set_redirect" class="btn upg-select-del-btn w-100">OK</a>
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
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/audio (1).png') }}" />
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
        var upload_type = document.getElementById('upload_type');
        upload_type.value = current;
        selectTypeRecording.style.display = "none";
        $("#downloadButton").click()
    }

    function recipentByName(current) {
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
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

    function validateForm() {
        var title = document.getElementById('title').value;
        var description = document.getElementById('description').value;
        var plan_details = JSON.parse('<?php echo json_encode($plan_details) ?>');
        var my_media = JSON.parse('<?php echo json_encode($my_media) ?>');
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var msg = '<span class="cl-white">Sorry format not matched! only alphanumeric characters allowed</span>';

        // if (format.test(title)) {
        //     $('#show_title_msg').empty();
        //     $("#show_title_msg").append(msg);
        //     return false;
        // }
        // if (format.test(description)) {
        //     $('#show_title_msg').empty();
        //     $('#show_description_msg').empty();
        //     $("#show_description_msg").append(msg);
        //     return false;
        // }
        if (my_media < plan_details[0].video_audio_limit) {
            $("#loader").modal("show");
            return true;
        } else {
            $('#show_title_msg').empty();
            $('#show_description_msg').empty();
            $('#show_msg').empty();
            $("#show_msg").append('<span class="cl-white">Sorry your limit for upload video / audio has been fully filled !</span>');
            return false;
        }
    }
</script>