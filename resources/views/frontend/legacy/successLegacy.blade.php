@extends("frontend.layouts.layout")
@section("title","Success Legacy")
@section("content")
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-6 offset-lg-3 text-center success-img-bg">
            <div class="row">
                <div class="col-lg-6 text-center offset-lg-3">
                    <h1 class="mt-4 text-white">Anna Seth</h1>
                    <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />
                    <p class="text-white">
                        You have successfully scheduled delivery of this memory on:
                        AUGUST 20, 2021
                    </p>
                    <div class="text-center mb-4">
                        <a href="#" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                        <a href="#" class="mx-1" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection