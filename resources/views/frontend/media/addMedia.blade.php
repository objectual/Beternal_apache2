@extends("frontend.layouts.layout")
@section("title","Add Media")
@section("content")
<div class="container-fluid bg-create mobile-padding vh-100 plr-0 add-media">
    <div class="scroll-div">
        <div class="row pb-5">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="d-flex home">
                    <div class="col text-center mob-view">
                        <a href="{{ route('user.media.capture-video') }}" class="">
                            <img src="{{ asset('/public/assets/images/video-circle.png') }}" class="video-circle" /> 
                            <p class="arial-bold mt-2">VIDEO</p>
                            <!-- <input type="file" accept="image/*;capture=camera"> -->
                        </a>
                    </div>
                    <div class="col text-center mob-view">
                        <a href="{{ route('user.media.capture-audio') }}" class="">
                        <img src="{{ asset('/public/assets/images/audio-circle.png') }}" class="audio-circle" /> 
                            
                            <p class="arial-bold mt-2">AUDIO</p>
                        </a>
                    </div>
                    <div class="col text-center mob-view">
                        <a href="{{ route('user.media.capture-image') }}" class="">
                            <img src="{{ asset('/public/assets/images/gallery-circle.png') }}" class="gallery-circle" /> 
                            
                            <p class="arial-bold mt-2">PHOTO</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <!-- <div class="row create-upload-btn">
                <div class="col-lg-2 col-6 offset-3 offset-lg-5">
                  <button class="btn w-100 btn-primary arial-bold btn-get">
                    GET STARTED
                  </button>
                </div>
              </div> -->
    </div>
</div>

<!-- Modal -->
<!-- <div class="modal-dialog modal-dialog-centered"> -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                hello 123
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
@endsection