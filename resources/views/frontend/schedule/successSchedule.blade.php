@extends("frontend.layouts.layout")
@section("title","Success Schedule")
@section("content")
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-6 offset-lg-3 text-center success-img-bg">
            <div class="row">
                <div class="col-lg-6 text-center offset-lg-3">
                    <h1 class="mt-4 text-white">Congratulations</h1>
                    <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />

                    @if(session()->has('message'))
                    <p class="text-white">
                        You have successfully scheduled delivery of this memory on:
                        {{ session()->get('message') }}
                    </p>
                    <div class="text-center mb-4">
                        <a href="{{ route('user.delivery') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection