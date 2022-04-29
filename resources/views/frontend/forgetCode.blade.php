@extends("frontend.layouts.layout")
@section("title","Forget Code")
@section("content")
<div class="container-fluid bg-create h-110  forget-back">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="login forget-login">
                    <a href="#" class="">
                        <img class="forget-cross" src="{{ asset('/public/assets/images/incorrect.png') }}" />
                    </a>
                    <h4 class="mt-3 mb-5 forget-head text-white">FORGET PASSWORD?</h4>
                    <p class="forget-para text-white">Enter 6 Digit Code Received on your Email</p>
                    <div id="form">
                        <input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" /><input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" /><input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />
                        <input class="input-text" type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" />


                    </div>
                    <a href="./forget-new-password.html" class="btn w-100 bg-black mb-3 m-auto text-center py-2 mt-3">
                        <span class="schedule">SUBMIT</span>
                    </a>
                    <a href="#" class="cl-black mb-5 resend-size">Resend</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection