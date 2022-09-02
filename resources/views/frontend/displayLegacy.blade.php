<link rel="stylesheet" href="{{ asset('/public/assets/css/lightbox.min.css') }}" />
@extends("frontend.layouts.layout")
@section("title","My Media")
@section("content")
@php
    $base_url = url('');
    if ($check_token != null) {
        $first_name = strtoupper($check_token->name);
        $last_name = strtoupper($check_token->last_name);
    } else {
        $first_name = '';
        $last_name = '';
    }
@endphp
<div class="container-fluid bg-create pt-2 pb-2 scroll-height-mobile mobile-padding my-media">
    <div class="col-lg-10 offset-lg-1">
        <div class="scroll-div">

            <div class="col-lg-6 mt-5 mb-5 m-auto FilterbyMediaType-btn">
                <select class="w-100 my-media-btn text-center" aria-label="Default select example" id="media_type" onChange="filterByMediaType()" required>
                    <option selected value="">Filter By Media Type</option>
                    <option value="video">Filter By Video</option>
                    <option value="audio">Filter By Audio</option>
                    <option value="photo">Filter By Photo</option>
                </select>
            </div>

            <h4 class="text-white text-center" id="video_heading">
                {{ $first_name }} {{ $last_name }} Legacy Videos
            </h4>
            <div class="row" id="video_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    @if(count($video_ids) > 0)
                        <div class="" id="current_video"></div>
                    @else
                        <p class="mb-0 contact-label text-center">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_videos">
                        @if(isset($user_legacy))
                            @foreach($user_legacy as $key => $video)
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
                                                    {{ $video->description }}
                                                </span>
                                            </div>
                                            <span class="ab-img-span">
                                                {{ $video->message }}
                                            </span>
                                            <span class="date-time pb-2">
                                                {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>

            <h4 class="mt-5 text-white text-center" id="photo_heading">
                {{ $first_name }} {{ $last_name }} Legacy Photos
            </h4>
            <div class="row" id="photo_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    @if(count($photo_ids) == 0)
                        <p class="mb-0 contact-label text-center">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_photos">
                        @if(isset($user_legacy))
                            @foreach($user_legacy as $key => $photo)
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
                                                        {{ $photo->description }}
                                                    </span>
                                                </div>
                                                <span class="ab-img-span">
                                                    {{ $photo->message }}
                                                </span>
                                                <span class="date-time pb-2">
                                                    {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>

            <h4 class="mt-5 text-white text-center" id="audio_heading">
                {{ $first_name }} {{ $last_name }} Legacy Audio
            </h4>
            <div class="row pb-5" id="audio_display">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 text-center mt-3">
                    @if(count($audio_ids) > 0)
                        <div class="audio" id="current_audio"></div>
                    @else
                        <p class="mb-0 contact-label">Not Found!</p>
                    @endif
                    <div class="row mt-3 px-2" id="all_audios">
                        @if(isset($user_legacy))
                            @foreach($user_legacy as $key => $audio)
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
                                                        {{ $audio->description }}
                                                    </span>
                                                </div>
                                                <span class="ab-img-span text-start">
                                                    {{ $audio->message }}
                                                </span>
                                                <span class="date-time pb-2">
                                                    {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                                </span>
                                            </div>
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
        var select_for_play = '<video id="mymedia_video" class="tv_video" controls><source src="' + base_path + current.id + for_device + '" type="' + set_format + '" />Your browser does not support the video tag.</video>';
        $('#current_video').empty();
        $("#current_video").append(select_for_play);
    }

    function selectAudio(current) {
        var base_path = '<?= $file_path ?>';
        var select_for_play = '<audio class="tv_audio" controls><source src="' + base_path + current.id + '" />Your browser does not support the video tag.</audio>';
        $('#current_audio').empty();
        $("#current_audio").append(select_for_play);
    }

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
</script>

<script src="{{ asset('/public/assets/js/lightbox-plus-jquery.min.js') }}"></script>