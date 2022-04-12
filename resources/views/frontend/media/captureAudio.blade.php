@extends("frontend.layouts.layout")
@section("title","Capture Audio")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div">
        <form method="POST" action="{{ route('user.medias.upload-media') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <input type="hidden" id="media_type" name="media_type" value="audio">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 mt-4">
                    <div class="d-flex mt-4">
                        <div class="col-md-4 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/audio.svg') }}" class="record-img">
                                </div>
                                <span class="" style="color: #ffaa00;">&nbsp;&nbsp;Record Audio</span>
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="#">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/device-gallery.svg') }}" class="gallery-img">
                                </div>
                                @if($errors->has('file_name'))
                                <div class="error">{{ $errors->first('file_name') }}</div>
                                @endif
                                <label style="color: #ffaa00;" for="file">&nbsp;&nbsp;Device Gallery</label>
                                <input type="file" accept="audio/*" name="file_name" id="file" style="display: none;">
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ route('user.medias.my-media') }}">
                                <div class="pb-3 media-icon-height">
                                    <img src="{{ asset('/public/assets/images/view-gallery.svg') }}" class="view-gallery-img">
                                </div>
                                <span class="" style="color: #ffaa00;">&nbsp;&nbsp;View Gallery</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="mb-3 w-100">
                            <label for="audio_title" class="form-label text-white">Audio Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control capture-form" placeholder="Audio Title Here" required>
                            <div class="col-12" id="show_title_msg"></div>
                        </div>
                        <div class="mb-3  w-100">
                            <label for="description" class="form-label  text-white" required>Description</label>
                            <textarea class="form-control capture-form" id="description" name="description" placeholder="Description Here">{{ old('description') }}</textarea>
                            <div class="col-12" id="show_description_msg"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 w-100">
                            <div class="">
                                <div class="input-group">
                                    <input type="text" id="name" class="form-control search-input" placeholder="Search by Recipient's Name">
                                    <div class="input-group-append">
                                        <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" id="main_serach_by_name" onclick="recipentByName(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white">Assign Recipient</p>
                        <div class="row mb-3" id="show_recipents">
                            @if(isset($user_recipents) && !$user_recipents->isEmpty())
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
                                    <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" id="main_serach_by_group" onclick="groupByName(this)" />
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
<div class="modal fade" id="captureImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <meta name="csrf-token" content="{{csrf_token()}}">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Recording</h2>
                        <audio id="preview" width="160" height="120" autoplay muted></audio><br /><br />
                        <div class="btn-group">
                            <div id="startButton" class="btn btn-success"> Start </div>
                            <div id="stopButton" class="btn btn-danger" style="display:none; margin-left:5px;"> Stop </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="recorded" style="display:none">
                        <h2>Preview</h2>
                        <audio id="recording" width="160" height="120" controls></audio><br /><br />
                        <a id="downloadLocalButton" class="btn btn-primary">Download</a>
                    </div>
                </div>

                <div class="container-fluid bg-create pb-4 h-auto upgrade-back mt-2">
                    <div class="scroll-div">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mt-2">
                                    <div class="mb-3 w-100">
                                        <label for="audio_title" class="form-label text-white">Audio Title</label>
                                        <input type="text" id="title_2" name="title_2" value="{{ old('title') }}" class="form-control capture-form" placeholder="Audio Title Here" required>
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
                                                    <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" id="modal_search_by_name" onclick="recipentByName(this)" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-white">Assign Recipient</p>
                                    <div class="row mb-3" id="show_recipents_2">
                                        @if(isset($user_recipents) && !$user_recipents->isEmpty())
                                        <div class="col-lg-2 col-3 rec-images">
                                            <img src="{{ asset('public/media/image/all-users.png') }}">
                                            <p class="cl-white sel-text mt-3">
                                                <input class="form-check-input" type="checkbox" id="all_recipient_2" name="all_recipient_2" value="all recipient" onclick="selectAllRecipient(this)">
                                                All
                                            </p>
                                        </div>
                                        @foreach($user_recipents as $key => $recipent)
                                        <div class="col-lg-2 col-3 rec-images">
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
                                                <img class="search-ico" src="{{ asset('public/assets/images/search.png')}}" id="modal_search_by_group" onclick="groupByName(this)" />
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

                    let recordingTimeMS = 10000; //audio limit 10 sec
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
                                    video: false,
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
                                        type: "audio/mp3"
                                    });
                                    recording.src = URL.createObjectURL(recordedBlob);

                                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                                    formData.append('file_name', recordedBlob);

                                    downloadLocalButton.href = recording.src;
                                    downloadLocalButton.download = "RecordedAudio.mp3";
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
                            if (format.test(title)) {
                                $('#show_title_msg_2').empty();
                                $("#show_title_msg_2").append(msg);
                                return false;
                            }
                            if (format.test(description)) {
                                $('#show_title_msg_2').empty();
                                $('#show_description_msg_2').empty();
                                $("#show_description_msg_2").append(msg);
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
                            formData.append('title', title);
                            formData.append('description', description);
                            for (var i = 0; i < recipient.length; i++) {
                                if (recipient[i].checked == true) {
                                    formData.append('recipient_id[]', recipient[i].value);
                                }
                            }
                            for (var i = 0; i < group.length; i++) {
                                if (group[i].checked == true) {
                                    formData.append('group_id[]', group[i].value);
                                }
                            }
                            if (title != '' && description != '') {
                                $.ajax({
                                    url: this.getAttribute('data-url'),
                                    method: 'POST',
                                    data: formData,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        if (res.success) {
                                            location.reload();
                                        }
                                    }
                                });
                            }
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
                        <img class="mt-4 mb-3 audio-pop" src="./images/video-pop.png" />
                        <p>
                            We have received your memory, which has been added to Your Legacy.

                        </p>
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

    function validateForm() {
        var title = document.getElementById('title').value;
        var description = document.getElementById('description').value;
        var plan_details = JSON.parse('<?php echo json_encode($plan_details) ?>');
        var my_media = JSON.parse('<?php echo json_encode($my_media) ?>');
        var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        var msg = '<span class="cl-white">Sorry format not matched! only alphanumeric characters allowed</span>';

        if (format.test(title)) {
            $('#show_title_msg').empty();
            $("#show_title_msg").append(msg);
            return false;
        }
        if (format.test(description)) {
            $('#show_title_msg').empty();
            $('#show_description_msg').empty();
            $("#show_description_msg").append(msg);
            return false;
        }
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