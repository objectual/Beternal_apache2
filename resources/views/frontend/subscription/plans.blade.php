@extends("frontend.layouts.layout")
@section("title","Subscription")
@section("content")
<div class="container-fluid bg-create pt-3 upgrade-back mobile-padding">

    <div class="scroll-div">
        <div class="upgrade-mobile">
            <h1> Tier</h1>
            <h4>You can choose any of the following subscription types and Enjoy unparallel Features on Beternal. We would love to see ur excitement</h4>
        </div>
        <div class="row">
            <div class="col-lg-3 col-11 offset-lg-3 mb-5 pay-succ upg-box">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="mt-4 payment-h3 upg-heading mb-5 text-white">FREE</h3>
                        <div class="row">
                            <div class="col-8 boder-grey">
                                <i class="fa fa-video-camera yellow-screen-icons"></i><span class="text-white upg-sub-heading"> Video</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                1(3min)
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-audio.png') }}"><span class="text-white upg-sub-heading"> Audio</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                1
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-album.png') }}"><span class="text-white upg-sub-heading"> Images</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                1
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-rec.png') }}"><span class="text-white upg-sub-heading"> Recipients</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                1
                            </div>

                        </div>
                    </div>
                    <button class="col-10 offset-lg-2 text-dark yellow-button">SELECT</button>
                </div>
            </div>
            <!-- new-div -->
            <div class="col-lg-3 col-11 mb-5 pay-succ upg-box upgrade-second-box">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="mt-4 payment-h3 upg-heading mb-5 text-white">PREMIUM</h3>
                        <div class="row">
                            <div class="col-8 boder-grey">
                                <i class="fa fa-video-camera yellow-screen-icons"></i><span class="text-white upg-sub-heading"> Video</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                Multiple
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-audio.png') }}"></i><span class="text-white upg-sub-heading"> Audio</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                Multiple
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-album.png') }}"><span class="text-white upg-sub-heading"> Images</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                Multiple
                            </div>
                            <div class="col-8 boder-grey">
                                <img class="yellow-screen-icons" src="{{ asset('/public/assets/images/tier-rec.png') }}"><span class="text-white upg-sub-heading"> Recipients</span>
                            </div>
                            <div class="col-4 yellow-screen-text text-white">
                                Multiple
                            </div>

                        </div>
                    </div>
                    <a href="{{ route('user.payment') }}" class="col-10 offset-lg-2 text-white bg-black yellow-button">UPGRADE</a>
                </div>
            </div>
            <!-- new-div -->
        </div>
    </div>


</div>
@endsection