@extends("frontend.layouts.layout")
@section("title","Our Solution")
@section("content")
<div class="bg-create scroll-height-mobile mobile-padding solution-bg">
    <div class="col-md-12 m-auto">
        <div class="scroll-div">
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
                        <a href="./create-account.html" class="solution-acc-btn">CREATE ACCOUNT</a>
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
                <div class="container-fluid text-center bg-black we-give-back-main">
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
                        <a href="./create-account.html" class="solution-sign-up-btn">SIGN UP</a>
                    </div>
                </div>
                <div class="container-fluid text-center reclaim-back-img">
                    <div class="col-md-7 p-5 m-auto">
                        <h1>
                            Reclaim your <br />
                            private life
                        </h1>
                    </div>
                </div>
                <div class="container-fluid p-5 text-center bg-black">
                    <div class="col-md-8 m-auto">
                        <h1 class="text-white">connect with us</h1>
                        <form>
                            <p class="text-white text-center mb-2 sol-page-labels">Name *</p>
                            <div class="row-one">
                                <div class="mb-3 col-md-6 name-form">
                                    <!-- <label for="exampleInputEmail1" class="form-label text-white">Email address</label> -->
                                    <input type="text" class="form-control sol-form" />
                                    <div id="emailHelp" class="form-text text-white">
                                        First Name
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <!-- <label for="exampleInputEmail1" class="form-label text-white">Email address</label> -->
                                    <input type="text" class="form-control sol-form" />
                                    <div id="emailHelp" class="form-text text-white">
                                        Last Name
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white sol-page-labels">Email *</label>
                                <input type="email" class="form-control sol-form" id="exampleInputPassword1" />
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white sol-page-labels">Phone</label>
                                <input type="text" class="form-control sol-form" id="exampleInputPassword1" />
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label text-white sol-page-labels">Message</label>
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