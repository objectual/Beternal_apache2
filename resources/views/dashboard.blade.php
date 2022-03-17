@extends("frontend.layouts.layout")
@section("title","Dashboard")
@section("content")
<div class="container-fluid login-back-light dashboard-back mobile-padding">
  <div class="scroll-div">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10 mt-4">
        <div class="row">
          <a href="{{ route('user.profile') }}" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/account.svg') }}" />

                <p class="dash-head mb-0 cl-white mt-3">ACCOUNT</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.recipents') }}" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/recipents-big.svg') }}" />

                <p class="dash-head mb-0 cl-white mt-3">RECIPIENTS</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.schedule-media') }}" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/scheduled-media.svg') }}" />

                <p class="dash-head mb-0 cl-white mt-3">SCHEDULED MEDIA</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.legacy') }}" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/legacy-big.svg') }}" />

                <p class="dash-head mb-0 cl-white mt-3">LEGACY</p>
              </div>
            </div>
          </a>
          <a href="{{ route('user.medias.my-media') }}" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/my-media.svg') }}" />

                <p class="dash-head mb-0 cl-white mt-3">MY MEDIA</p>
              </div>
            </div>
          </a>
          <a href="#" class="col-lg-6 mt-3 text-center position-relative col-6">
            <div class=" p-3 dashboard-contain">
              <div class="col m-auto text-center">
                <img class="" src="{{ asset('/public/assets/images/upgrade.svg') }}" />

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