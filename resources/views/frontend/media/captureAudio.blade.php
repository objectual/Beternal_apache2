@extends("frontend.layouts.layout")
@section("title","Capture Audio")
@section("content")
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 mt-4">
                <div class="d-flex mt-4">
                    <div class="col-md-4 text-center">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#captureImage">
                            <div class="pb-3 media-icon-height">
                                <img src="{{ asset('/public/assets/images/audio.svg') }}" class="record-img">
                            </div>
                            <span class="" style="color: #ffaa00;">&nbsp;&nbsp;Record Audio</span>
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="#">
                            <div class="pb-3 media-icon-height">
                                <img src="{{ asset('/public/assets/images/device-gallery.svg') }}" class="gallery-img">
                            </div>
                            <span class="" style="color: #ffaa00;">&nbsp;&nbsp;Device Gallery</span>
                        </a>
                    </div>
                    <div class="col-md-4 text-center">
                        <a href="{{ route('user.medias.my-media') }}">
                            <div class="pb-3 media-icon-height">
                                <img src="{{ asset('/public/assets/images/view-gallery.svg') }}" class="view-gallery-img">
                            </div>
                            <span class="" style="color: #ffaa00;">&nbsp;&nbsp;View Gallery</span>
                        </a>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="mb-3 w-100">
                        <label for="exampleInputEmail1" class="form-label text-white">Audio Title</label>
                        <input type="text" class="form-control capture-form" placeholder="Enter here">
                    </div>
                    <div class="mb-3  w-100">
                        <label for="exampleInputPassword1" class="form-label  text-white">Description</label>
                        <textarea class="form-control capture-form" placeholder="Description Here"></textarea>
                    </div>
                </div>
                <div class="row m-0 mb-3">
                    <div class="col-lg-2 p-0 col-4 text-white">Date:</div>
                    <div class="col-lg-7 col-2"></div>
                    <div class="col-lg-3 col-6 text-white text-end p-0">22/11/2021</div>
                </div>
                <div class="row">
                    <p class="text-white">Assign Recipient</p>
                    <div class="row mb-3">
                        <div class="col-lg-2 col-3 rec-images"><img src="{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}"></div>
                        <div class="col-lg-2 col-3 rec-images"><img src="{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}"></div>
                        <div class="col-lg-2 col-3 rec-images"><img src="{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}"></div>
                    </div>
                </div>
                <p class="text-white">Select Group</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label text-white" for="inlineRadio1">Friends</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label text-white" for="inlineRadio2">Family</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                    <label class="form-check-label text-white" for="inlineRadio3">Others</label>
                </div>
                <div class="row pt-4">
                    <div class="col-12 ">
                        <button data-bs-toggle="modal" data-bs-target="#redirectModal" class="btn upg-add-img-btn w-100">Save Your Memory</button>
                    </div>
                    <!-- <div class="col-12 mt-3 ">
                                    <a href="./delivery.html" class="btn upg-select-del-btn w-100">Select Delivery</a>
                                 </div> -->
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade" id="captureImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 text-center offset-lg-3">
                        <img class="mt-4 mb-5 audio-pop" src="{{ asset('/public/assets/images/audio-pop.png') }}" />
                        <p>
                            To Record Audio, bETERNAL needs permission to access Mic
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
</div>

<!-- Redirect Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade" id="redirectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8 text-center offset-lg-2">
                        <img class="mt-4 mb-3 audio-pop" src="./images/video-pop.png" />
                        <p>
                            We have received your memory, which has been added to Your Legacy.

                        </p>
                        </p>
                        <!-- <div class="row text-center mb-4 mt-5">
                           <div class="col-lg-6">
                               <a href="./schedule-media.html" class="btn upg-select-del-btn w-100">Scheduled Media</a>
                           </div>
                           <div class="col-lg-6">
                              <a href="./legacy.html" class="btn upg-select-del-btn w-100">Legacy</a>
                           </div>                           
                        </div> -->
                        <div class="row text-center mb-4 mt-5">
                            <div class="col-lg-6 offset-lg-3">
                                <a href="./legacy.html" class="btn upg-select-del-btn w-100">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection