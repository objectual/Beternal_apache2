@extends("frontend.layouts.layout")
@section("title","Capture Video")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div">
        @if (Session::has('status'))
        <div class="alert alert-success text-center" role="alert">
            {{ Session::get('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('user.medias.upload-media') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <input type="hidden" id="media_type" name="media_type" value="video">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 mt-4">
                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-4 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                                <div class="pb-3">
                                    <img src="{{ asset('/public/assets/images/video.png') }}" class="record-video">
                                </div>
                                <span class="d-block record-images" style="color: #F7DB02;">&nbsp;&nbsp;Record Video</span>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a>
                                <div class="pb-3">
                                    <label class="record-images" style="color: #F7DB02;" for="file"><img src="{{ asset('/public/assets/images/device-gallery.png') }}" class="gallery-img"></label>
                                </div>
                                @if($errors->has('file_name'))
                                <div class="error">{{ $errors->first('file_name') }}</div>
                                @endif
                                <label class="record-images" style="color: #F7DB02;" for="file">&nbsp;&nbsp;Device Gallery</label>
                                <input type="file" accept="video/*" name="file_name" id="file" style="display: none;" onchange="loadFile(event)">
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
                                <div class="pb-3">
                                    <img src="{{ asset('/public/assets/images/view-gallery.png') }}" class="view-gallery-img">
                                </div>
                                <span class="record-images" style="color: #F7DB02;">&nbsp;&nbsp;View Gallery</span>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div class="col-md-12 text-center" id="attachment"></div>
                    </div>

                    <div class="mt-5">
                        <div class="mb-3 w-100">
                            <label for="video_title" class="form-label text-white">Video Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control capture-form" placeholder="Video Title Here" required>
                            <div class="col-12" id="show_title_msg"></div>
                        </div>
                        <div class="mb-3 w-100">
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
                    <div class="row pt-4">
                        <div class="col-12 ">
                            <button class="btn upg-add-img-btn w-100">Save Your Memory</button>
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
                <meta name="csrf-token" content="{{csrf_token()}}">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="text-white">Recording</h2>
                        <video id="preview" class="record-video-area" autoplay muted></video><br />
                        <div class="btn-group mt-4">
                            <div id="startButton" class="start-rec-btn"> Start </div>
                            <div id="stopButton" class="stop-btn btn btn-danger" style="display:none; margin-left:5px;"> Stop </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="recorded" style="display:none">
                        <h2>Preview</h2>
                        <video id="recording" class="record-video-area" controls></video><br />
                        <a id="downloadLocalButton" class="start-rec-btn mt-4 d-inline-flex">Download</a>
                    </div>
                </div>

                <div class="pb-4 mt-2">
                    <div class="scroll-div">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-2">
                                    <div class="mb-3 w-100">
                                        <label for="video_title" class="form-label text-white">Video Title</label>
                                        <input type="text" id="title_2" name="title_2" value="{{ old('title') }}" class="form-control capture-form" placeholder="Video Title Here">
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

                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script>
                    let preview = document.getElementById("preview");
                    let recording = document.getElementById("recording");
                    let startButton = document.getElementById("startButton");
                    let stopButton = document.getElementById("stopButton");
                    let downloadButton = document.getElementById("downloadButton");
                    let logElement = document.getElementById("log");
                    let recorded = document.getElementById("recorded");
                    let downloadLocalButton = document.getElementById("downloadLocalButton");

                    let recordingTimeMS = 10000; //video limit 10 sec
                    var localstream;

                    window.log = function(msg) {
                        //logElement.innerHTML += msg + "\n";
                        console.log(msg);
                    }

                    window.wait = function(delayInMS) {
                        return new Promise(resolve => setTimeout(resolve, delayInMS));
                    }

                    window.startRecording = function(stream, lengthInMS) {
                        let recorder = new MediaRecorder(stream);
                        let data = [];

                        recorder.ondataavailable = event => data.push(event.data);
                        recorder.start();
                        log(recorder.state + " for " + (lengthInMS / 1000) + " seconds...");

                        let stopped = new Promise((resolve, reject) => {
                            recorder.onstop = resolve;
                            recorder.onerror = event => reject(event.name);
                        });

                        let recorded = wait(lengthInMS).then(
                            () => recorder.state == "recording" && recorder.stop()
                        );

                        return Promise.all([
                                stopped,
                                recorded
                            ])
                            .then(() => data);
                    }

                    window.stop = function(stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    var formData = new FormData();
                    if (startButton) {
                        startButton.addEventListener("click", function() {
                            startButton.innerHTML = "recording...";
                            recorded.style.display = "none";
                            stopButton.style.display = "inline-block";
                            downloadButton.innerHTML = "rendering..";
                            navigator.mediaDevices.getUserMedia({
                                    video: true,
                                    audio: true
                                }).then(stream => {
                                    preview.srcObject = stream;
                                    localstream = stream;
                                    //downloadButton.href = stream;
                                    preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                                    return new Promise(resolve => preview.onplaying = resolve);
                                }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
                                .then(recordedChunks => {
                                    let recordedBlob = new Blob(recordedChunks, {
                                        type: "video/webm"
                                    });
                                    recording.src = URL.createObjectURL(recordedBlob);

                                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                                    formData.append('file_name', recordedBlob);

                                    downloadLocalButton.href = recording.src;
                                    downloadLocalButton.download = "RecordedVideo.webm";
                                    log("Successfully recorded " + recordedBlob.size + " bytes of " +
                                        recordedBlob.type + " media.");
                                    startButton.innerHTML = "Start";
                                    stopButton.style.display = "none";
                                    recorded.style.display = "block";
                                    downloadButton.innerHTML = "Save Your Memory";
                                    localstream.getTracks()[0].stop();
                                })
                                .catch(log);
                        }, false);
                    }
                    if (downloadButton) {
                        downloadButton.addEventListener("click", function() {
                            let media_type = document.getElementById("media_type").value;
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
                            // if (format.test(title)) {
                            //     $('#show_title_msg_2').empty();
                            //     $("#show_title_msg_2").append(msg);
                            //     return false;
                            // }
                            // if (format.test(description)) {
                            //     $('#show_title_msg_2').empty();
                            //     $('#show_description_msg_2').empty();
                            //     $("#show_description_msg_2").append(msg);
                            //     return false;
                            // }
                            if (my_media >= plan_details[0].video_audio_limit) {
                                $('#show_title_msg_2').empty();
                                $('#show_description_msg_2').empty();
                                $('#show_msg_2').empty();
                                $("#show_msg_2").append('<span class="cl-white">Sorry your limit for upload video / audio has been fully filled !</span>');
                                return false;
                            }
                            formData.append('media_type', media_type);
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
                            if (selected_recipient == 0) {
                                $('#recipient_msg').empty();
                                $("#recipient_msg").append(msg_recipient);
                                return false;
                            }
                            if (selected_group == 0) {
                                $('#recipient_msg').empty();
                                $('#group_msg').empty();
                                $("#group_msg").append(msg_group);
                                return false;
                            }
                            $.ajax({
                                url: this.getAttribute('data-url'),
                                method: 'POST',
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    if (res.success) {
                                        $("#redirectModal").modal("show");
                                        // location.reload();
                                    }
                                }
                            });
                        }, false);
                    }
                    if (stopButton) {
                        stopButton.addEventListener("click", function() {
                            stop(preview.srcObject);
                            startButton.innerHTML = "Start";
                            stopButton.style.display = "none";
                            recorded.style.display = "block";
                            downloadButton.innerHTML = "Save";
                            localstream.getTracks()[0].stop();
                        }, false);
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
                        <img class="mt-4 mb-3 audio-pop" src="{{ asset('/public/assets/images/video-pop.png') }}" />
                        <p>Uploaded successfully.</p>
                        <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6 offset-lg-3">
                                <a href="{{ route('user.medias.capture-video') }}" class="btn upg-select-del-btn w-100">OK</a>
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