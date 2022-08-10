@extends("frontend.layouts.layout")
@section("title","Welcome")

@section("content")
<div class="container-fluid bg index-back">
    <div class="d-flex pt-5">
        <div class="col text-center">
            <a href="{{ route('user.media') }}">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 p-0-m">
                        <video class="landing_video" controls>
                            <source src="{{ asset('/public/assets/images/home-video.mp4#t=0.001') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
                <!-- <img class="play-img" src="{{ asset('/public/assets/images/play.svg')}}" /></a> -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 offset-lg-5 text-center">
            <a href="{{ route('user.media') }}" class="btn btn-primary arial-bold btn-get">
                GET STARTED
            </a>
        </div>
    </div>
</div>
@endsection