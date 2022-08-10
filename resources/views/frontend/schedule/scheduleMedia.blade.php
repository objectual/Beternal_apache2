<link rel="stylesheet" href="{{ asset('/public/assets/css/lightbox.min.css') }}" />
@extends("frontend.layouts.layout")
@section("title","Schedule Media")
@section("content")
<div class="container-fluid shared-back-light mobile-padding pb-5 scheduled-media">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="scroll-div">
                <div class="row pt-3 pb-3">
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

                <div class="row">
                    <div class="col-lg-12">
                        <a class=" " href="#">
                            <div class="video">
                                <video id="ban_video" class="tv_video" controls>
                                    <source src="{{ asset('/public/assets/images/solution.mp4#t=0.001') }}" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>

                                <!-- <div class="play-bt"></div>
                                <div class="pause-bt" style="display: none"></div> -->
                            </div>
                            <div class="bg-black legacy-main-box">
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <span class="ab-img-span">Nina Brethart</span>
                                    </div>
                                    <div class="col-lg-6 col-6 text-end">
                                        <span class="above-img-span">Group 2</span>
                                    </div>
                                </div>
                                <span class="above-img-span">First Contact</span>
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
                <div class="row mt-3 px-2 pb-4">
                <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
                                        <span class="above-img-span">12-05-2022 10:08 PM</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-6 px-1 col-4 col-md-4">
                        <a class="example-image-link legacy-images-text" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <!-- <img class="example-image"
                              src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/> -->
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
                                    <div class="col-lg-8 col-8 text-end legacy-padding-text">
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
<script src="{{ asset('/public/assets/js/lightbox-plus-jquery.min.js') }}"></script>