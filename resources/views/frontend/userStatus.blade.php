@extends("frontend.layouts.layout")
@section("title","User Status")
@section("content")
@if(isset($message))
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-4 offset-lg-4 text-center success-img-bg">
            <div class="row">
                <div class="col-lg-8 text-center offset-lg-2">
                    <h5 class="mt-5 payment-h3 text-white">{{ $message }}</h5>
                    <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />
                    <div class="text-center mb-4">
                        <a href="{{ route('splash') }}" class="btn w-100 bg-black mb-3 m-auto text-center py-2 mt-3">
                            <span class="schedule text-white">CONTINUE</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(isset($token))
<div class="modal-dialog reject-modal modal-sm">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row pt-3 pb-5 media-icons mt-4">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <a href="{{ url('status-success/'.$token) }}">
                        <button class="filter-btn btn w-100 text-center py-2 mt-2">
                            Yes, I am OK
                        </button>
                    </a>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection