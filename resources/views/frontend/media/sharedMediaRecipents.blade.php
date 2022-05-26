@extends("frontend.layouts.layout")
@section("title","Share Media Recipients")
@section("content")
<div class="container-fluid shared-back-light mobile-padding bg-repeat-size schedule-media-back pb-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="scroll-div">
                <div class="row pt-3 pb-5">
                    <div class="col-lg-1">
                        <p class="filter-text text-white">FILTER BY:</p>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="input-group filter-select sch-media-form">
                            <input type="text" class="form-control search-input" placeholder="Search by Recipient's Name">
                            <div class="input-group-append">
                                <a href="#"><img class="search-ico" src="{{ asset('/public/assets/images/search-white.png') }}" /> </a>
                            </div>
                        </div>
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

                <div class="row">
                    <div class="col-lg-12">
                        <a class=" " href="#">
                            <div class="video">
                                <video id="ban_video" class="tv_video" controls>
                                    <source src="{{ asset('/public/assets/images/landing-video.mp4') }}" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>

                                <!-- <div class="play-bt"></div>
                                <div class="pause-bt" style="display: none"></div> -->
                            </div>
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <span class="ab-img-span">Nina Brethart</span>
                                    </div>
                                    <div class="col-lg-6 col-6 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="above-img-span">Video 1 30-11-2021 3:04pm</span>
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-6 col-6 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row mt-3 px-2">
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="ab-img-span">Nina Brethart</span>
                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="above-img-span">First Contact</span>
                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="bg-black border-shared-img">
                                <div class="row">
                                    <div class="col-lg-7 col-7">
                                        <span class="above-img-span">First Contact</span>

                                    </div>
                                    <div class="col-lg-5 col-5 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="ab-img-span">Nina Brethart</span>

                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <span class="above-img-span">Image</span>
                                    </div>
                                    <div class="col-lg-8 col-8 text-end">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection