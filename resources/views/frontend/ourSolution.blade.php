@extends("frontend.layouts.layout")
@section("title","Our Solution")
@section("content")
<div class="scroll-height-mobile mobile-padding">
    <div class="col-md-12 m-auto">
        <div class="scroll-div bg-solution">
            <div class="row">
                <div class="container-fluid p-5 second-section-solution">
                    <div class="col-md-8 text-center m-auto our-sol-inner-div">
                        <h1 class="text-white pb-4">OUR SOLUTION</h1>
                        <p class="text-white pb-4">
                            You have little control over who sees your personal memories, and
                            to make matters worse, they are owned by the social media giants
                            to use at their discretion without your consent and in perpetuity.
                            Further, once you are out of their ecosystem, for one reason or
                            another, those precious clips are potentially lost forever.
                            According to Big Social, your “private” data is anything but.
                        </p>
                        <a href="{{ route('register') }}" class="solution-acc-btn">CREATE ACCOUNT</a>
                    </div>
                </div>
                <div class="container-fluid break-free-back">
                    <div class="col-md-8 m-auto text-center text-white p-5">
                        <h1>
                            Break free from<br />
                            the status quo
                        </h1>
                    </div>
                    
                </div>
                <div class="container-fluid text-center we-give-back-main">
                    <div class="col-md-7 p-4 m-auto text-white we-give-back">
                        <h1 class="pb-4">
                            We give back <br />
                            your power…
                        </h1>
                        <p>
                            and your rights. You are now in control of every aspect of your
                            legacy. We place<br />
                            your memories in our vault and only release them when the time is
                            right. Your<br />
                            legacy. Your way. Be eternal.
                        </p>
                        <a href="{{ route('register') }}" class="solution-sign-up-btn mt-4 d-block">SIGN UP</a>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6 p-0-m">
                        <video class="landing_video" controls>
                            <source src="{{ asset('/public/assets/images/solution.mp4#t=0.001') }}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
                </div>
                <div class="container-fluid text-center reclaim-back-img">
                    <div class="col-md-7 p-5 m-auto">
                        <h1 class="text-white">
                            Reclaim your <br />
                            private life
                        </h1>
                    </div>
                </div>
                <div class="container-fluid p-5 text-center bg-black">
                    <div class="col-md-8 m-auto">
                        <h1 class="text-white mb-4">connect with us</h1>
                        <form>
                            <div class="row-one">
                                <div class="mb-3 col-lg-6 col-12 name-form">
                                     <label for="exampleInputPassword1" class="form-label text-white sol-page-labels text-start d-block">First Name *</label>
                                    <input type="text" class="form-control sol-form" />
                                 
                                </div>
                                <div class="mb-3 col-lg-6 col-12">                                    
                                    <label for="exampleInputPassword1" class="form-label text-white sol-page-labels text-start d-block">Last Name *</label>
                                    <input type="text" class="form-control sol-form" />
                                   
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white sol-page-labels text-start d-block">Email *</label>
                                <input type="email" class="form-control sol-form" id="exampleInputPassword1" />
                            </div>
                            <div class="mb-3 phone-area">
                                <label for="exampleInputPassword1" class="form-label text-white sol-page-labels text-start d-block">Phone</label>
                                <input type="text" class="form-control sol-form" id="exampleInputPassword1" />
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label text-white sol-page-labels text-start d-block">Message</label>
                                <textarea class="form-control sol-form" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary send-bthn-solution col-md-2 col-12">
                                Send
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection