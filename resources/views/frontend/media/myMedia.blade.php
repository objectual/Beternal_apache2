@extends("frontend.layouts.layout")
@section("title","My Media")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create pt-2 pb-2 scroll-height-mobile mobile-padding">
    <div class="col-lg-10 offset-lg-1">
        <div class="scroll-div">

            <div class="row pt-3 pb-5 media-icons">
                <div class="col-lg-1">
                    <p class="filter-text text-white">FILTER BY:</p>
                </div>
                <div class="col-lg-4 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Seach by Recipent's Name</option>
                    </select>
                    <p class="media-rec-text mb-0">View all Recipients</p>
                </div>
                <div class="col-lg-2 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Group</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-2">
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
                </div>
                <div class="col-lg-2">
                    <button class="filter-btn
                                btn
                                w-100 
                                text-center
                                py-2 
                              ">Search
                    </button>
                </div>
            </div>

            <div class="d-flex icons-clr-chnage">
                <div class="col text-center mob-view">
                    <a href="{{ route('user.medias.capture-video') }}" class="icon-video media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD VIDEO</p>
                        <!-- <input type="file" accept="image/*;capture=camera"> -->
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="{{ route('user.medias.capture-audio') }}" class="icon-audio active media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD AUDIO</p>
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="{{ route('user.medias.capture-image') }}" class="icon-photos media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD PHOTO</p>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mb-5 m-auto FilterbyMediaType-btn">
                <button class="w-100 my-media-btn">Filter by Media Type</button>
            </div>

            <h4 class="text-white text-center">My Video</h4>
            <div class="row">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    <div class="video" id="current_video">
                        <video id="ban_video" class="tv_video" controls>
                            <source src="{{ asset('/public/assets/images/video.mp4') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>
            <div class="row mt-3 px-2">
                @if(isset($videos))
                @foreach($videos as $key => $video)
                @php $date_time = explode(" ", $video->created_at); @endphp
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" id="{{ $video->file_name }}" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="selectVideo(this)"><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <div class="play-bt-exm-one"></div>
                        <span class="above-img-span">{{ $video->title }}</span>
                        <span class="above-img-span">{{ $date_time[0] }} &nbsp; {{ $date_time[1] }}</span>
                    </a>
                </div>
                @endforeach
                @endif
            </div>

            <h4 class="mt-4 text-white text-center">My Photo</h4>
            <div class="row">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    <div class="image" id="current_photo">
                        <picture id="ban_image" class="tv_image">
                            <img src="@if(!$photos->isEmpty()){{ asset( 'public/'.$photos[0]->file_name )}}@else{{ asset('/public/assets/images/my-media-default-image.jpg') }}@endif" type="image" height="500" width="720" />
                        </picture>
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>
            <div class="row mt-3 px-2">
                @if(isset($photos))
                @foreach($photos as $key => $photo)
                @php $date_time = explode(" ", $photo->created_at); @endphp
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" id="{{ $photo->file_name }}" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="selectPhoto(this)"><img class="example-image" src="{{ asset( 'public/'.$photo->file_name )}}" alt="" />
                        <span class="ab-img-span">{{ $photo->recipient_first_name }} {{ $photo->recipient_last_name }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group : {{ $photo->group_title }}</span></span>
                        <!-- <span class="above-img-span">First Contact</span> -->
                        <span class="above-img-span">{{ $photo->title }}<span class="date-time"> {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}</span></span></a>
                </div>
                @endforeach
                @endif
            </div>

            <h4 class="mt-4 text-white text-center">My Audio</h4>
            <div class="row">
                <div class="col-lg-2 mt-3"></div>
                <div class="col-lg-8 mt-3">
                    <div class="audio" id="current_audio">
                        <audio id="ban_audio" class="tv_audio" controls>
                            <source src="{{ asset('/public/assets/images/game_play_music.mp3') }}" type="audio/mp3" />
                            Your browser does not support the video tag.
                        </audio>
                    </div>
                </div>
                <div class="col-lg-2 mt-3"></div>
            </div>
            <div class="row mt-3 px-2">
                @if(isset($audios))
                @foreach($audios as $key => $audio)
                @php $date_time = explode(" ", $audio->created_at); @endphp
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" id="{{ $audio->file_name }}" data-lightbox="example-set" data-title="Click the right half of the image to move forward." onclick="selectAudio(this)"><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="above-img-span">{{ $audio->title }}</span>
                        <span class="above-img-span">{{ $date_time[0] }} &nbsp; {{ $date_time[1] }}</span>
                    </a>
                </div>
                @endforeach
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    function selectVideo(current) {
        var base_url = '<?= $base_url ?>';
        var base_path = base_url + '/public/';
        var select_for_play = '<video id="ban_video" class="tv_video" controls><source src="' + base_path + current.id + '" />Your browser does not support the video tag.</video>';
        $('#current_video').empty();
        $("#current_video").append(select_for_play);
    }

    function selectAudio(current) {
        var base_url = '<?= $base_url ?>';
        var base_path = base_url + '/public/';
        var select_for_play = '<audio id="ban_audio" class="tv_audio" controls><source src="' + base_path + current.id + '" />Your browser does not support the video tag.</audio>';
        $('#current_audio').empty();
        $("#current_audio").append(select_for_play);
    }

    function selectPhoto(current) {
        var base_url = '<?= $base_url ?>';
        var base_path = base_url + '/public/';
        var select_for_show = '<picture id="ban_image" class="tv_image"><img src="' + base_path + current.id + '" type="image" height="500" width="720" /></picture>';
        $('#current_photo').empty();
        $("#current_photo").append(select_for_show);
    }
</script>