@extends("frontend.layouts.layout")
@section("title","Subscription Successfull")
@section("content")
<div class="container-fluid pt-5 pb-5 success-bg">
    <div class="row pt-3">
        <div class="col-lg-5 m-auto text-center success-img-bg">
            <div class="scroll-div">
                <div class="row">
                    <div class="col-lg-8 text-center offset-lg-2">
                        <h2 class="mt-5 payment-h3 text-white">WELCOME</h2>
                        <h6 class="text-white pay-para">You have successfully subscribed.</h6>
                        <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />
                        <div class="text-center mb-4">
                            <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn pay-succ-btn mb-3 m-auto text-center py-2 mt-3">
                                <span class="schedule">GOT IT</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection