@extends("frontend.layouts.layout")
@section("title","Welcome")

@section("content")
<div class="container-fluid bg index-back">
    <div class="d-flex pt-5">
        <div class="col text-center">
            <a href="{{ route('user.medias') }}"><img class="play-img" src="{{ asset('/public/assets/images/play.svg')}}" /></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 offset-lg-5 text-center">
            <a href="{{ route('user.medias') }}" class="btn btn-primary arial-bold btn-get">
                GET STARTED
            </a>
        </div>
    </div>
</div>
@endsection