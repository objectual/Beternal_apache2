@extends("frontend.layouts.layout")
@section("title","Splash")
@section("content")
@if(session()->has('message'))
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">{{ session()->get('message') }}</p>
                    <div class="text-center mb-4">
                        <a href="{{ route('index') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="loader">
    <div class="splash-main">
        <div class="bg-sp-1 px-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2"></div>

                    <div class="col-lg-8">
                        <p class="sp-head-1">
                            bETERNAL is a secure legacy-creation and preservation platform.
                        </p>
                        <p class="sp-head-2">
                            In a time where social media wants to permanently and mindlessly
                            tell the story of your life through your digital footprint, we
                            invite you to take your story back.
                        </p>
                        <div class="row">
                            <div class="col-lg-12 p-0-m">
                                <video class="landing_video" controls>
                                    <source src="{{ asset('/public/assets/images/solution.mp4#t=0.001') }}" type="video/mp4" />
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <p class="sp-head-2">
                            Through interactive prompts, we help you tell your life story and
                            share it with only those you choose.
                        </p>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>
        <div class="row bg-sp-2 px-5">
            <div class="col-12">
                <p class="sp-head-1 pb-4">will you bETERNAL?</p>
                <p class="sp-head-2">
                    You determine your legacy.. <br />. Let us deliver your story
                    <br />the way you want.
                </p>
            </div>
        </div>
        <div class="row bg-mobile px-5">
            <div class="col-12">
                <p class="sp-head-1">OUR VISION</p>
                <p class="sp-head-2 pb-4">
                    is to ensure that you have the opportunity to share your legacy.
                </p>
                <p class="sp-head-1 m-0">bETERNAL is a legacy vault</p>
                <p class="sp-head-2 pb-4">
                    Our mission is to provide an engaging, intuitive, universal application that securely stores and distributes your wisdom,<br> knowledge, and memories for future generations.
                </p>
            </div>
        </div>
        <div class="row bg-sp-3 px-5">
            <div class="col-12">
                <p class="sp-head-1 pb-2 pt-4">CAPTURE YOUR TRUTH</p>
                <p class="sp-head-2 pb-5">
                    Preserve your memories.<br />
                    Record your thoughts, feelings, and experiences to share with
                    loved ones when and how you wish.<br />
                    Completely private and not accessible by the public.
                </p>
            </div>
        </div>
        <div class="row bg-mobile px-5">
            <div class="col-12">
                <p class="sp-head-2 pt-4">
                    A safety deposit box for your private memories.
                </p>
                <p class="sp-head-2">
                    These memories are only for your designated recipients. Period.
                </p>
                <p class="sp-head-1 pb-3">Safe. Secure. Timeless.</p>
                <a href="{{ route('our-solution') }}" class="splash-btn mb-5 m-auto d-block">OUR SOLUTION</a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection