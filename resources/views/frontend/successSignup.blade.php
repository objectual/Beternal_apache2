@extends("frontend.layouts.layout")
@section("title","Success Signup")
@section("content")
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-4 offset-lg-4 text-center success-img-bg">
            <div class="row">
                <div class="col-lg-8 text-center offset-lg-2">
                    <h5 class="mt-5 payment-h3 text-white">YOU DID IT!</h5>
                    <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />
                    <div class="text-center mb-4">
                        <a href="{{ route('dashboard') }}" class="btn w-100 bg-black mb-3 m-auto text-center py-2 mt-3">
                            <span class="schedule text-white">CONTINUE</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection