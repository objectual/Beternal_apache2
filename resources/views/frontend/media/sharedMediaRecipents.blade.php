@extends("frontend.layouts.layout")
@section("title","Share Media Recipients")
@section("content")
<div class="container-fluid bg-create pt-2 pb-2 scroll-height-mobile mobile-padding">
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
                <div class="col-lg-2">
                    <button class="filter-btn btn w-100 text-center py-2" onclick="filterMedia()">Search</button>
                </div>
            </div>

            <h4 class="text-white text-center" id="video_heading">Video</h4>
            <div class="row" id="video_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    <div class="" id="current_video">
                        <video id="ban_video" class="tv_video" controls>
                            <source src="{{ asset('/public/assets/images/landing-video.mp4#t=0.001') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="row mt-3 px-2" id="all_videos">
                        @if(isset($all_media))
                        @foreach($all_media as $key => $video)
                        @if($video->type == 'video')
                        @php $date_time = explode(" ", $video->created_at); @endphp
                        <div class="col-lg-3 px-1 col-6 col-md-4">
                            <a class="example-image-link d-block" id="{{ $video->file_name }}" onclick="selectVideo(this)">
                                <img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
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
                                    {{ $video->sender_first_name }} {{ $video->sender_last_name }}
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

            <h4 class="mt-5 text-white text-center" id="photo_heading">Photo</h4>
            <div class="row" id="photo_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
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
                                        {{ $photo->sender_first_name }} {{ $photo->sender_last_name }}
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


            <h4 class="mt-5 text-white text-center" id="audio_heading">Audio</h4>
            <div class="row pb-5" id="audio_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 text-center mt-3">
                    <div class="audio" id="current_audio">
                        <audio id="ban_audio" class="tv_audio" controls>
                            <source src="{{ asset('/public/assets/images/game_play_music.mp3') }}" type="audio/mp3" />
                            Your browser does not support the video tag.
                        </audio>
                    </div>
                    <div class="row mt-3 px-2" id="all_audios">
                        @if(isset($all_media))
                        @foreach($all_media as $key => $audio)
                        @if($audio->type == 'audio')
                        @php $date_time = explode(" ", $audio->created_at); @endphp
                        <div class="col-lg-3 px-1 col-md-4 col-6">
                            <a class="example-image-link d-block" id="{{ $audio->file_name }}" onclick="selectAudio(this)">
                                <img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
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
                                        {{ $audio->sender_first_name }} {{ $audio->sender_last_name }}
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
        var select_for_play = '<video id="ban_video" class="tv_video" controls><source src="' + base_path + current.id + for_device + '" type="' + set_format + '" />Your browser does not support the video tag.</video>';
        $('#current_video').empty();
        $("#current_video").append(select_for_play);
    }

    function selectAudio(current) {
        var base_path = '<?= $file_path ?>';
        var select_for_play = '<audio id="ban_audio" class="tv_audio" controls><source src="' + base_path + current.id + '" />Your browser does not support the video tag.</audio>';
        $('#current_audio').empty();
        $("#current_audio").append(select_for_play);
    }

    function filterMedia() {
        var for_recipient = document.getElementById('recipient_id').value;
        var for_group = document.getElementById('group_title').value;
        var all_media = JSON.parse('<?php echo json_encode($all_media) ?>');
        var user_groups = JSON.parse('<?php echo json_encode($user_groups) ?>');
        var base_path = '<?= $file_path ?>';
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
            if (user_groups != null) {
                var user_groups_len = user_groups.length;
            } else {
                var user_groups_len = 0;
            }
            if (user_groups_len > 0) {
                for (var i = 0; i < user_groups_len; i++) {
                    if (user_groups[i].group_title == for_group) {
                        var media_len = user_groups[i].media.length;
                        for (var j = 0; j < media_len; j++) {
                            var group = user_groups[i].media[j];
                            if (group.sender_id == for_recipient) {
                                var file_name = group.file_name;
                                var name = group.sender_first_name;
                                var last_name = group.sender_last_name;
                                var media_title = group.title;
                                var date_time = new Date(group.created_at);
                                var year = date_time.getFullYear();
                                var month = date_time.getMonth();
                                var date = date_time.getDate();
                                var hour = date_time.getHours();
                                var minute = date_time.getMinutes();
                                var second = date_time.getSeconds();
                                var display_time = hour + ':' + minute + ':' + second;
                                var display_date = year + '-' + month + '-' + date;
                                if (group.type == 'video') {
                                    var media_function = 'selectVideo(this)';
                                    var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                    var media_button = 'play-bt-exm-one';
                                }
                                if (group.type == 'audio') {
                                    var media_function = 'selectAudio(this)';
                                    var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                    var media_button = 'audio-bt-exm-one';
                                }
                                if (group.type == 'photo') {
                                    var media_function = '';
                                    var file = base_path + file_name;
                                    var media_button = '';
                                }
                                var route_url = 'my-media-details/' + group.id;
                                var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '"><img class="example-image" src="' + file + '" alt="" /><div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + for_group + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                                if (group.type == 'video') {
                                    all_videos.append(media);
                                }
                                if (group.type == 'audio') {
                                    all_audios.append(media);
                                }
                                if (group.type == 'photo') {
                                    all_photos.append(media);
                                }
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
                    if (for_recipient == all_media[i].sender_id) {
                        var file_name = all_media[i].file_name;
                        var name = all_media[i].sender_first_name;
                        var last_name = all_media[i].sender_last_name;
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
                            var media_function = 'selectVideo(this)';
                            var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                            var media_button = 'play-bt-exm-one';
                        }
                        if (all_media[i].type == 'audio') {
                            var media_function = 'selectAudio(this)';
                            var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                            var media_button = 'audio-bt-exm-one';
                        }
                        if (all_media[i].type == 'photo') {
                            var media_function = '';
                            var file = base_path + file_name;
                            var media_button = '';
                        }
                        var route_url = 'my-media-details/' + all_media[i].id;
                        var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '"><img class="example-image" src="' + file + '" alt="" /><div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + all_media[i].group_title + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
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
        } else if (for_group != '') {
            all_videos.empty();
            all_audios.empty();
            all_photos.empty();
            if (user_groups != null) {
                var user_groups_len = user_groups.length;
            } else {
                var user_groups_len = 0;
            }
            if (user_groups_len > 0) {
                for (var i = 0; i < user_groups_len; i++) {
                    if (user_groups[i].group_title == for_group) {
                        var media_len = user_groups[i].media.length;
                        for (var j = 0; j < media_len; j++) {
                            var group = user_groups[i].media[j];
                            var file_name = group.file_name;
                            var name = group.sender_first_name;
                            var last_name = group.sender_last_name;
                            var media_title = group.title;
                            var date_time = new Date(group.created_at);
                            var year = date_time.getFullYear();
                            var month = date_time.getMonth();
                            var date = date_time.getDate();
                            var hour = date_time.getHours();
                            var minute = date_time.getMinutes();
                            var second = date_time.getSeconds();
                            var display_time = hour + ':' + minute + ':' + second;
                            var display_date = year + '-' + month + '-' + date;
                            if (group.type == 'video') {
                                var media_function = 'selectVideo(this)';
                                var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                var media_button = 'play-bt-exm-one';
                            }
                            if (group.type == 'audio') {
                                var media_function = 'selectAudio(this)';
                                var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                                var media_button = 'audio-bt-exm-one';
                            }
                            if (group.type == 'photo') {
                                var media_function = '';
                                var file = base_path + file_name;
                                var media_button = '';
                            }
                            var route_url = 'my-media-details/' + group.id;
                            var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '"><img class="example-image" src="' + file + '" alt="" /><div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + for_group + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
                            if (group.type == 'video') {
                                all_videos.append(media);
                            }
                            if (group.type == 'audio') {
                                all_audios.append(media);
                            }
                            if (group.type == 'photo') {
                                all_photos.append(media);
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
                    var name = all_media[i].sender_first_name;
                    var last_name = all_media[i].sender_last_name;
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
                        var media_function = 'selectVideo(this)';
                        var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                        var media_button = 'play-bt-exm-one';
                    }
                    if (all_media[i].type == 'audio') {
                        var media_function = 'selectAudio(this)';
                        var file = 'http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg';
                        var media_button = 'audio-bt-exm-one';
                    }
                    if (all_media[i].type == 'photo') {
                        var media_function = '';
                        var file = base_path + file_name;
                        var media_button = '';
                    }
                    var route_url = 'my-media-details/' + all_media[i].id;
                    var media = '<div class="col-lg-3 px-1 col-6 col-md-4"><a class="example-image-link d-block" id="' + file_name + '" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="' + media_function + '"><img class="example-image" src="' + file + '" alt="" /><div class="' + media_button + '"></div><div class="d-flex pt-1 bg-black"><span class="above-img-span">' + media_title + '</span><span class="group-color">Group : ' + all_media[i].group_title + '</span></div><span class="ab-img-span">' + name + ' ' + last_name + '</span><span class="date-time pb-2">' + display_date + ' &nbsp; ' + display_time + '</span></a><a href="' + route_url + '" class="btn-view-details">View Details </a></div>';
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