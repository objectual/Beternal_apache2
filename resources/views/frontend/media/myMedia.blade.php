<link rel="stylesheet" href="{{ asset('/public/assets/css/lightbox.min.css') }}" />
@extends("frontend.layouts.layout")
@section("title","My Media")
@section("content")
@php $base_url = url(''); @endphp
@if(session()->has('message'))
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">{{ session()->get('message') }}</p>
                    <div class="text-center mb-4">
                        <a href="{{ route('user.media.my-media') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid bg-create pt-2 pb-2 scroll-height-mobile mobile-padding my-media">
    <div class="col-lg-10 offset-lg-1">
        <div class="scroll-div">

            <div class="row pt-3 pb-5 media-icons">
                <div class="col-lg-1">
                    <p class="filter-text text-white">FILTER BY:</p>
                </div>
                <div class="col-lg-4 mb-2">
                    <select id="recipient_id" class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected value="">Seach by Recipent's Name</option>
                        @if(isset($user_recipents))
                        @foreach($user_recipents as $key => $recipient)
                        <option value="{{ $recipient->recipient_id }}">
                            {{ $recipient->name }} {{ $recipient->last_name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    <p class="media-rec-text mb-0">View all Recipients</p>
                </div>
                <div class="col-lg-4 mb-2">
                    <select id="group_title" class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected value="">Group</option>
                        @if(isset($user_groups))
                        @foreach($user_groups as $key => $group)
                        <option value="{{ $group->group_title }}">
                            {{ $group->group_title }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <!-- <div class="col-lg-2 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Status</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button class="sort-btn d-flex justify-content-center
                      btn
                      mb-2
                      w-100 
                      text-center
                      py-2 
                    "><img src="{{ asset('/public/assets/images/sort.svg') }}">
                        <span class="mx-2 sort-txt d-none">Sort By Date</span>
                    </button>
                </div> -->
                <div class="col-lg-2">
                    <button class="filter-btn btn w-100 text-center py-2" onclick="filterMedia()">Search</button>
                </div>
            </div>

            <div class="d-flex icons-clr-chnage">
                <div class="col text-center mob-view">
                    <a href="{{ route('user.media.capture-video') }}" class="">
                        <img src="{{ asset('/public/assets/images/video-circle.png') }}" class="shared-video-circle" />

                        <p class="arial-bold text-white mt-2">UPLOAD VIDEO</p>
                        <!-- <input type="file" accept="image/*;capture=camera"> -->
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="{{ route('user.media.capture-audio') }}" class="">
                        <img src="{{ asset('/public/assets/images/audio-circle.png') }}" class="shared-audio-circle" />

                        <p class="arial-bold text-white mt-2">UPLOAD AUDIO</p>
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="{{ route('user.media.capture-image') }}" class="">
                        <img src="{{ asset('/public/assets/images/gallery-circle.png') }}" class="shared-gallery-circle" />

                        <p class="arial-bold text-white mt-2">UPLOAD PHOTO</p>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mb-5 m-auto FilterbyMediaType-btn">
                <select class="w-100 my-media-btn text-center" aria-label="Default select example" id="media_type" onChange="filterByMediaType()" required>
                    <option selected value="">Filter By Media Type</option>
                    <option value="video">Filter By Video</option>
                    <option value="audio">Filter By Audio</option>
                    <option value="photo">Filter By Photo</option>
                </select>
                <!-- <button class="w-100 my-media-btn">Filter by Media Type</button> -->
            </div>

            <h4 class="text-white text-center" id="video_heading">My Video</h4>
            <div class="row" id="video_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    @if($video_count > 0)
                    <div class="" id="current_video"></div>
                    @else
                    <p class="mb-0 contact-label text-center">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_videos">
                        @if(isset($all_media))
                        @foreach($all_media as $key => $video)
                        @if($video->type == 'video')
                        @php
                        $date_time = explode(" ", $video->created_at);
                        $format = explode(".", $video->file_name);
                        $ios = '#t=0.001';
                        if ($format[1] == 'mov') {
                        $set_format = 'video/mp4';
                        } else {
                        $set_format = 'video/'.$format[1];
                        }
                        @endphp
                        <div class="col-lg-3 px-1 col-6 col-md-4">
                            <a class="example-image-link d-block" id="{{ $video->file_name }}" onclick="selectVideo(this)">
                                <video class="example-image">
                                    <source src="{{ asset( $file_path.$video->file_name.$ios )}}" type="{{ $set_format }}">
                                </video>
                                <div class="play-bt-exm-one"></div>
                                <div class="pt-1 bg-black">
                                    <span class="above-img-span">
                                        {{ $video->title }}
                                    </span>

                                    <span class="group-color">
                                        Group : {{ $video->group_title }}
                                    </span>
                                </div>
                                <span class="ab-img-span">
                                    {{ $video->recipient_first_name }} {{ $video->recipient_last_name }}
                                </span>

                                <span class="date-time pb-2">
                                    {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                </span>
                            </a>
                            <a href="{{ route('user.media.my-media-details', ['id' => $video->id]) }}" class="btn-view-details">
                                View Details
                            </a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>

            <h4 class="mt-5 text-white text-center" id="photo_heading">My Photo</h4>
            <div class="row" id="photo_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    @if($photo_count == 0)
                    <p class="mb-0 contact-label text-center">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_photos">
                        @if(isset($all_media))
                        @foreach($all_media as $key => $photo)
                        @if($photo->type == 'photo')
                        @php $date_time = explode(" ", $photo->created_at); @endphp
                        <div class="col-lg-3 px-1 col-6 col-md-4">
                            <a class="example-image-link" href="{{ asset( $file_path.$photo->file_name )}}" id="{{ $photo->file_name }}" data-lightbox="example-set" data-title="<span>{{ $photo->description }}</span><br /><span>{{ $photo->created_at }}</span>" onclick="">
                                <img class="example-image" src="{{ asset( $file_path.$photo->file_name )}}" alt="" />

                                <div class="bg-black p-1">
                                    <div class="d-flex pt-1 bg-black">
                                        <span class="above-img-span">
                                            {{ $photo->title }}

                                        </span>

                                        <span class="group-color">
                                            Group : {{ $photo->group_title }}
                                        </span>
                                    </div>
                                    <span class="ab-img-span">
                                        {{ $photo->recipient_first_name }} {{ $photo->recipient_last_name }}
                                    </span>

                                    <span class="date-time pb-2">
                                        {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                    </span>
                                </div>
                            </a>
                            <a href="{{ route('user.media.my-media-details', ['id' => $photo->id]) }}" class="btn-view-details">
                                View Details
                            </a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>


            <h4 class="mt-5 text-white text-center" id="audio_heading">My Audio</h4>
            <div class="row pb-5" id="audio_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 text-center mt-3">
                    @if($audio_count > 0)
                    <div class="audio" id="current_audio"></div>
                    @else
                    <p class="mb-0 contact-label">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_audios">
                        @if(isset($all_media))
                        @foreach($all_media as $key => $audio)
                        @if($audio->type == 'audio')
                        @php $date_time = explode(" ", $audio->created_at); @endphp
                        <div class="col-lg-3 px-1 col-md-4 col-6">
                            <a class="example-image-link d-block" id="{{ $audio->file_name }}" onclick="selectAudio(this)">
                                <img class="example-image" src="{{ asset('/public/assets/images/audio-thumb.jpg') }}" alt="" />
                                <div class="audio-bt-exm-one"></div>

                                <div class="bg-black p-1">
                                    <div class="pt-1 bg-black">
                                        <span class="above-img-span text-start">
                                            {{ $audio->title }}

                                        </span>

                                        <span class="group-color">
                                            Group : {{ $audio->group_title }}
                                        </span>
                                    </div>
                                    <span class="ab-img-span text-start">
                                        {{ $audio->recipient_first_name }} {{ $audio->recipient_last_name }}
                                    </span>

                                    <span class="date-time pb-2">
                                        {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                    </span>
                                </div>

                            </a>
                            <a href="{{ route('user.media.my-media-details', ['id' => $audio->id]) }}" class="btn-view-details">
                                View Details
                            </a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>


        </div>
    </div>
</div>
@endif
@endsection

<script type="text/javascript">
    function selectVideo(current) {
        var base_path = '<?= $file_path ?>';
        var for_device = '#t=0.001';
        var my_file = current.id.split(".");
        var set_format = '';
        if (my_file[1] == 'mov') {
            set_format = 'video/mp4';
        } else {
            set_format = 'video/' + my_file[1];
        }
        // var base_path = base_url + '/public/';
        var select_for_play = '<video id="mymedia_video" class="tv_video" controls><source src="' + base_path + current.id + for_device + '" type="' + set_format + '" />Your browser does not support the video tag.</video>';
        $('#current_video').empty();
        $("#current_video").append(select_for_play);
    }

    function selectAudio(current) {
        var base_path = '<?= $file_path ?>';
        // var base_path = base_url + '/public/';
        var select_for_play = '<audio class="tv_audio" controls><source src="' + base_path + current.id + '" />Your browser does not support the video tag.</audio>';
        $('#current_audio').empty();
        $("#current_audio").append(select_for_play);
    }

    // function selectPhoto(current) {
    //     var base_path = '<?= $file_path ?>';
    //     var base_path = base_url + '/public/';
    //     var select_for_show = '<picture id="ban_image" class="tv_image"><img src="' + base_path + current.id + '" type="image" height="500" width="720" /></picture>';
    //     $('#current_photo').empty();
    //     $("#current_photo").append(select_for_show);
    // }

    function filterByMediaType() {
        var video_heading = document.getElementById('video_heading');
        var photo_heading = document.getElementById('photo_heading');
        var audio_heading = document.getElementById('audio_heading');
        var select = document.getElementById('media_type');
        var option = select.options[select.selectedIndex];
        if (option.value == 'video') {
            video_heading.textContent = 'My Video';
            photo_heading.textContent = '';
            audio_heading.textContent = '';
            $('#video_display').show();
            $('#all_videos').show();
            $('#photo_display').hide();
            $('#all_photos').hide();
            $('#audio_display').hide();
            $('#all_audios').hide();
        }
        if (option.value == 'photo') {
            photo_heading.textContent = 'My Photo';
            video_heading.textContent = '';
            audio_heading.textContent = '';
            $('#photo_display').show();
            $('#all_photos').show();
            $('#video_display').hide();
            $('#all_videos').hide();
            $('#audio_display').hide();
            $('#all_audios').hide();
        }
        if (option.value == 'audio') {
            audio_heading.textContent = 'My Audio';
            video_heading.textContent = '';
            photo_heading.textContent = '';
            $('#audio_display').show();
            $('#all_audios').show();
            $('#video_display').hide();
            $('#all_videos').hide();
            $('#photo_display').hide();
            $('#all_photos').hide();
        }
        if (option.value == '') {
            video_heading.textContent = 'My Video';
            photo_heading.textContent = 'My Photo';
            audio_heading.textContent = 'My Audio';
            $('#video_display').show();
            $('#all_videos').show();
            $('#photo_display').show();
            $('#all_photos').show();
            $('#audio_display').show();
            $('#all_audios').show();
        }
    }

    function filterMedia() {
        var for_recipient = document.getElementById('recipient_id').value;
        var for_group = document.getElementById('group_title').value;
        var all_media = JSON.parse('<?php echo json_encode($all_media) ?>');
        var base_path = '<?= $file_path ?>';
        // var base_path = base_url + '/public/';
        var all_videos = $('#all_videos');
        var all_audios = $('#all_audios');
        var all_photos = $('#all_photos');

        if (all_media != null) {
            var all_media_len = all_media.length;
        } else {
            var all_media_len = 0;
        }

        if (for_recipient != '' && for_group != '') {
            all_videos.empty();
            all_audios.empty();
            all_photos.empty();
            if (all_media_len > 0) {
                for (var i = 0; i < all_media_len; i++) {
                    if (all_media[i].all_recipient != null) {
                        var all_recipient_len = all_media[i].all_recipient.length;
                        for (var j = 0; j < all_recipient_len; j++) {
                            var recipient = all_media[i].all_recipient[j];
                            if (for_recipient == recipient.recipient_id && for_group == all_media[i].group_title) {
                                var file_name = all_media[i].file_name;
                                var name = recipient.name;
                                var last_name = recipient.last_name;
                                var media_title = all_media[i].title;
                                var date_time = new Date(all_media[i].created_at);
                                var year = date_time.getFullYear();
                                var month = date_time.getMonth();
                                var date = date_time.getDate();
                                var hour = date_time.getHours();
                                var minute = date_time.getMinutes();
                                var second = date_time.getSeconds();
                                var display_time = hour + ':' + minute + ':' + second;
                                var display_date = year + '-' + month + '-' + date;
                                if (all_media[i].type == 'video') {
                                    var my_file = file_name.split(".");
                                    var set_format = '';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var media_function = 'selectVideo(this)';
                                    var file = base_path + file_name + '#t=0.001';
                                    var media_button = 'play-bt-exm-one';
                                    var for_display = '<video class="example-image"><source src="' + file + '" type="' + set_format + '"></video>';
                                }
                                if (all_media[i].type == 'audio') {
                                    var media_function = 'selectAudio(this)';
                                    var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                    var media_button = 'audio-bt-exm-one';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                if (all_media[i].type == 'photo') {
                                    var media_function = '';
                                    var file = base_path + file_name;
                                    var media_button = '';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                var route_url = 'my-media-details/' + all_media[i].id;
                                var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '">' + for_display + '<div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + for_group + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                                if (all_media[i].type == 'video') {
                                    all_videos.append(media);
                                }
                                if (all_media[i].type == 'audio') {
                                    all_audios.append(media);
                                }
                                if (all_media[i].type == 'photo') {
                                    all_photos.append(media);
                                }
                                j = all_recipient_len;
                            }
                        }
                    }
                }
            }
        } else if (for_recipient != '') {
            all_videos.empty();
            all_audios.empty();
            all_photos.empty();
            if (all_media_len > 0) {
                for (var i = 0; i < all_media_len; i++) {
                    if (all_media[i].all_recipient != null) {
                        var all_recipient_len = all_media[i].all_recipient.length;
                        for (var j = 0; j < all_recipient_len; j++) {
                            var recipient = all_media[i].all_recipient[j];
                            if (for_recipient == recipient.recipient_id) {
                                var file_name = all_media[i].file_name;
                                var name = recipient.name;
                                var last_name = recipient.last_name;
                                var media_title = all_media[i].title;
                                var date_time = new Date(all_media[i].created_at);
                                var year = date_time.getFullYear();
                                var month = date_time.getMonth();
                                var date = date_time.getDate();
                                var hour = date_time.getHours();
                                var minute = date_time.getMinutes();
                                var second = date_time.getSeconds();
                                var display_time = hour + ':' + minute + ':' + second;
                                var display_date = year + '-' + month + '-' + date;
                                if (all_media[i].type == 'video') {
                                    var my_file = file_name.split(".");
                                    var set_format = '';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var media_function = 'selectVideo(this)';
                                    var file = base_path + file_name + '#t=0.001';
                                    var media_button = 'play-bt-exm-one';
                                    var for_display = '<video class="example-image"><source src="' + file + '" type="' + set_format + '"></video>';
                                }
                                if (all_media[i].type == 'audio') {
                                    var media_function = 'selectAudio(this)';
                                    var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                    var media_button = 'audio-bt-exm-one';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                if (all_media[i].type == 'photo') {
                                    var media_function = '';
                                    var file = base_path + file_name;
                                    var media_button = '';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                var route_url = 'my-media-details/' + all_media[i].id;
                                var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '">' + for_display + '<div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + all_media[i].group_title + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                                if (all_media[i].type == 'video') {
                                    all_videos.append(media);
                                }
                                if (all_media[i].type == 'audio') {
                                    all_audios.append(media);
                                }
                                if (all_media[i].type == 'photo') {
                                    all_photos.append(media);
                                }
                                j = all_recipient_len;
                            }
                        }
                    }
                }
            }
        } else if (for_group != '') {
            all_videos.empty();
            all_audios.empty();
            all_photos.empty();
            if (all_media_len > 0) {
                for (var i = 0; i < all_media_len; i++) {
                    if (all_media[i].all_recipient != null) {
                        var all_group_len = all_media[i].all_group.length;
                        for (var j = 0; j < all_group_len; j++) {
                            var group = all_media[i].all_group[j];
                            if (for_group == group.group_title) {
                                var file_name = all_media[i].file_name;
                                var name = all_media[i].recipient_first_name;
                                var last_name = all_media[i].recipient_last_name;
                                var media_title = all_media[i].title;
                                var date_time = new Date(all_media[i].created_at);
                                var year = date_time.getFullYear();
                                var month = date_time.getMonth();
                                var date = date_time.getDate();
                                var hour = date_time.getHours();
                                var minute = date_time.getMinutes();
                                var second = date_time.getSeconds();
                                var display_time = hour + ':' + minute + ':' + second;
                                var display_date = year + '-' + month + '-' + date;
                                if (all_media[i].type == 'video') {
                                    var my_file = file_name.split(".");
                                    var set_format = '';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var media_function = 'selectVideo(this)';
                                    var file = base_path + file_name + '#t=0.001';
                                    var media_button = 'play-bt-exm-one';
                                    var for_display = '<video class="example-image"><source src="' + file + '" type="' + set_format + '"></video>';
                                }
                                if (all_media[i].type == 'audio') {
                                    var media_function = 'selectAudio(this)';
                                    var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                    var media_button = 'audio-bt-exm-one';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                if (all_media[i].type == 'photo') {
                                    var media_function = '';
                                    var file = base_path + file_name;
                                    var media_button = '';
                                    var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                                }
                                var route_url = 'my-media-details/' + all_media[i].id;
                                var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '">' + for_display + '<div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + for_group + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                                if (all_media[i].type == 'video') {
                                    all_videos.append(media);
                                }
                                if (all_media[i].type == 'audio') {
                                    all_audios.append(media);
                                }
                                if (all_media[i].type == 'photo') {
                                    all_photos.append(media);
                                }
                                j = all_recipient_len;
                            }
                        }
                    }
                }
            }
        } else if (for_recipient == '' && for_group == '') {
            all_videos.empty();
            all_audios.empty();
            all_photos.empty();
            if (all_media_len > 0) {
                for (var i = 0; i < all_media_len; i++) {
                    var file_name = all_media[i].file_name;
                    var name = all_media[i].recipient_first_name;
                    var last_name = all_media[i].recipient_last_name;
                    var media_title = all_media[i].title;
                    var date_time = new Date(all_media[i].created_at);
                    var year = date_time.getFullYear();
                    var month = date_time.getMonth();
                    var date = date_time.getDate();
                    var hour = date_time.getHours();
                    var minute = date_time.getMinutes();
                    var second = date_time.getSeconds();
                    var display_time = hour + ':' + minute + ':' + second;
                    var display_date = year + '-' + month + '-' + date;
                    if (all_media[i].type == 'video') {
                        var my_file = file_name.split(".");
                        var set_format = '';
                        if (my_file[1] == 'mov') {
                            set_format = 'video/mp4';
                        } else {
                            set_format = 'video/' + my_file[1];
                        }
                        var media_function = 'selectVideo(this)';
                        var file = base_path + file_name + '#t=0.001';
                        var media_button = 'play-bt-exm-one';
                        var for_display = '<video class="example-image"><source src="' + file + '" type="'+ set_format +'"></video>';
                    }
                    if (all_media[i].type == 'audio') {
                        var media_function = 'selectAudio(this)';
                        var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                        var media_button = 'audio-bt-exm-one';
                        var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                    }
                    if (all_media[i].type == 'photo') {
                        var media_function = '';
                        var file = base_path + file_name;
                        var media_button = '';
                        var for_display = '<img class="example-image" src="' + file + '" alt="" />';
                    }
                    var route_url = 'my-media-details/' + all_media[i].id;
                    var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '">' + for_display + '<div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + all_media[i].group_title + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                    if (all_media[i].type == 'video') {
                        all_videos.append(media);
                    }
                    if (all_media[i].type == 'audio') {
                        all_audios.append(media);
                    }
                    if (all_media[i].type == 'photo') {
                        all_photos.append(media);
                    }
                }
            }
        }
    }
</script>

<script src="{{ asset('/public/assets/js/lightbox-plus-jquery.min.js') }}"></script>