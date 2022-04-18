@extends("frontend.layouts.layout")
@section("title","My Media Details")
@section("content")
<div class="container-fluid shared-back-light pt-5 pb-3  bg-calendar">
    <div class="col-lg-10 offset-lg-1 my-media-detail-padding">
        <div class="scroll-div">
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class=" col-md-12 col-12 justify-content-end d-flex ">
                        <img src="{{ asset('/public/assets/images/edit-icon-media-details.png') }}" class="edit-icon-style">
                        <p style="color:#F7DB02;" class="px-2">Edit</p>
                        <img src="{{ asset('/public/assets/images/delete-new.png') }}" class="delete-icon-style">
                        <p style="color:#C91717;" class="px-2">Delete</p>
                    </div>
                    <div class="video">
                        <video id="ban_video" class="tv_video">
                            <source src="{{ asset('/public/assets/images/video.mp4') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>

                        <div class="play-bt"></div>
                        <div class="pause-bt" style="display: none"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-lg-4 text-start">
                    <p class="media-head text-white">LOREM IPSUM DOLOR AMIT SED TU ES</p>
                </div>
                <div class="col-lg-2 col-4 text-white media-head">
                    <p>Group</p>
                </div>
                <div class="col-lg-6 col-8 text-end">
                    <p class="media-clock-p text-white"><img class="media-clock-img" src="{{ asset('/public/assets/images/clock.png') }}" />&nbsp;12:33 AM 11-12-2021</p>
                </div>
            </div>

            <div class="row mt-1">
                <div class="row d-flex">
                    <div class="col-md-1 col-3"><img class="media-recipent" src="{{ asset('/public/assets/images/recipent.png') }}"></div>
                    <div class="text-white col-md-2 p-0 col-5 details-text">NINA BRETHERT<br>@username</div>
                    <div class="text-white col-md-1 px-0 pt-3 col-4 details-text-two">Mid level</div>
                    <!-- <span class="media-clock-p text-white"><img class="media-recipent" src="./images/recipent.png" /><span><span>NINA BRETHERT</span><br><span>@username</span></span></span> -->
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-lg-12">
                    <p class="media-head text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection