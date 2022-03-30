@extends("frontend.layouts.layout")
@section("title","My Media")
@section("content")
<div class="container-fluid bg-create pt-2 pb-2 scroll-height-mobile mobile-padding">
    <div class="col-lg-10 offset-lg-1">
        <div class="scroll-div">
            <div class="row pt-3 pb-5 media-icons">
                <div class="col-lg-1">
                    <p class="filter-text text-white">FILTER BY:</p>
                </div>
                <div class="col-lg-4 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Seach by Recipent's Name</option>
                    </select>
                    <p class="media-rec-text mb-0">View all Recipients</p>
                </div>
                <div class="col-lg-2 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Group</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-2">
                    <select class="form-select filter-select sch-media-form" aria-label="Default select example">
                        <option selected>Status</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button class="sort-btn d-flex justify-content-center
                      btn
                      mb-2
                      w-100 
                      text-center
                      py-2 
                    "><img src="{{ asset('/public/assets/images/sort.svg') }}">
                        <span class="mx-2 sort-txt d-none">Sort By Date</span>
                    </button>
                </div>
                <div class="col-lg-2">
                    <button class="filter-btn
                                btn
                                w-100 
                                text-center
                                py-2 
                              ">Search
                    </button>
                </div>
            </div>

            <div class="d-flex icons-clr-chnage">
                <div class="col text-center mob-view">
                    <a href="#" class="icon-video media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD VIDEO</p>
                        <!-- <input type="file" accept="image/*;capture=camera"> -->
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="#" class="icon-audio active media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD AUDIO</p>
                    </a>
                </div>
                <div class="col text-center mob-view">
                    <a href="#" class="icon-photos media-icon-clr">
                        <p class="arial-bold text-white mt-2">UPLOAD PHOTO</p>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mb-5 m-auto FilterbyMediaType-btn">
                <button class="w-100 my-media-btn">Filter by Media Type</button>
            </div>
            <h4 class="text-white">My Video</h4>
            <div class="row">
                <div class="col-lg-12 mt-3">
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
            <div class="row mt-3 px-2">
                @if(isset($videos))
                @foreach($videos as $key => $video)
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <div class="play-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">{{ $video->title }} <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                @endforeach
                @endif
            </div>
            <h4 class="mt-4 text-white">My Photo</h4>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class="video">
                        <video id="ban_video" class="tv_video">
                            <source src="{{ asset('/public/assets/images/video.mp4') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            <div class="row mt-3 px-2">
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div> -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div>  -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-5.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-5.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div> -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-6.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div> -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div> -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" />
                        <!-- <div class="play-bt-exm-one"></div> -->
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span></a>
                </div>
            </div>
            <h4 class="mt-4 text-white">My Audio</h4>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class="video">
                        <video id="ban_video" class="tv_video">
                            <source src="{{ asset('/public/assets/images/video.mp4') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                        <div class="audio-icon-bt"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3 px-2">
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-5.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-5.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-6.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
                <div class="col-lg-2 px-1 col-12">
                    <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" />
                        <div class="audio-bt-exm-one"></div>
                        <span class="ab-img-span">Nina Brethart &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="group-color">Group 2</span></span>
                        <span class="above-img-span">First Contact</span>
                        <span class="above-img-span">Video 1 <span class="date-time"> 30-11-2021 &nbsp; 3:04pm</span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection