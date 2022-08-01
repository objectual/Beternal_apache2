@extends("frontend.layouts.layout")
@section("title","Dashboard")
@section("content")
<div class="container-fluid login-back-light dashboard-back mobile-padding">
  <div class="scroll-div splash-height center-cent">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10">
        <div class="row">
          <a href="{{ route('user.profile') }}" class="col-lg-4 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/person.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">ACCOUNT</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.recipents') }}" class="col-lg-4 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/recipients.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">RECIPIENTS</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.delivery') }}" class="col-lg-4 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/calendar.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">SCHEDULED MEDIA</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.legacy') }}" class="col-lg-4 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/leaf.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">LEGACY</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.media.my-media') }}" class="col-lg-4 mb-dash mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/media.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">MY MEDIA</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.payment') }}" class="col-lg-4 mb-dash mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/plus.png') }}" />

                <p class="dash-head mb-0 cl-white mt-3">UPGRADE</p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-1"></div>
    </div>

  </div>
</div>
@endsection