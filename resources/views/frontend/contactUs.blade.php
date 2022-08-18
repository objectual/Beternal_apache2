@extends("frontend.layouts.layout")
@section("title","Contact Us")
@section("content")
<div class="container-fluid bg-create forget-back contact-back">
  <div class="scroll-div row-height">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="login contact-us">
          <h4 class="mt-3 mb-3 forget-head text-white">CONNECT WITH US</h4>
          <div class=" mb-3">
            <div class="row">
              <div class="col-md-6 col-sm-12 mb-2">
                <input type="email" class="privacy-placeholder form-control forget-border-form" placeholder="First Name" aria-label="Email" aria-describedby="basic-addon1" />
              </div>
              <div class="col col-md-6 col-sm-12 mb-2">
                <input type="email" class="privacy-placeholder form-control forget-border-form" placeholder="Last Name" aria-label="Email" aria-describedby="basic-addon1" />
              </div>
            </div>
            <div class="row mb-2">
              <div class="col">
                <input type="email" class="privacy-placeholder form-control forget-border-form" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" />
              </div>
            </div>
            <div class="row">
              <div class="col">
                <textarea class="form-control forget-border-form privacy-placeholder" row="4" placeholder="Your Message" aria-label="Email" aria-describedby="basic-addon1" style="margin-top: 0px; margin-bottom: 0px; height: 301px;"></textarea>
              </div>
            </div>
          </div>
          <div class="col-lg-6 offset-lg-3 ">
            <img class="w-100 mb-4" src="{{ asset('/public/assets/images/captcha.PNG') }}">
            <a href="./thank-you.html" class="btn w-100 bg-yell mb-3 m-auto text-center py-2 mt-1">
              <span class="schedule">Send</span>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection