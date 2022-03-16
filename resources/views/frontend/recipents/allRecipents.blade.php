@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")

<div class="container-fluid bg-create scroll-height-mobile mobile-padding recipent-padding-bottom">
    <div class="col-md-10 m-auto">
        <div class="scroll-div">
            <div class="row">
                <div class="row p-3 col-12 padding-recipent">
                    <div class="col-md-2">
                        <h5 class="cl-white filter-heading">FILTER BY:</h5>
                    </div>
                    <div class="col-md-4 mb-2 padding-right-mobile-rec">
                        <div class="">
                            <div class="input-group">
                                <input type="text" class="form-control search-input"
                                    placeholder="Search by Recipient's Name">
                                <div class="input-group-append">
                                    <a href="#"><img class="search-ico"
                                            src="{{ asset('public/assets/images/search.png')}}" /> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <select class="form-select padding-custom" id="validationCustom04" required>
                            <option selected disabled value="">Group</option>
                            <option>...</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <select class="form-select padding-custom" id="validationCustom04" required>
                            <option selected disabled value="">Status</option>
                            <option>...</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-2 mb-2 padding-right-mobile-rec">
                        <button class="select-recipent-btn">Search</button>
                    </div>
                </div>
            </div>
            <div class="row select-recipent-bottom-padding">
                <div class="col-lg-2 col-4 text-center">
                    <a href="{{ route('user.recipents.add-form') }}" class="">
                        <img class="recipent-img" src="{{ asset('public/assets/images/add.svg')}}" />
                        <p class="sel-text color-primary mt-3">Add </p>
                    </a>
                </div>
                @if(isset($user_recipents))
                @foreach($user_recipents as $key => $recipent)
                <div class="col-lg-2 text-center col-4 position-relative">
                    <img class="recipent-img" src="{{ asset($recipent->profile_image)}}" />
                    <p class="cl-white sel-text mt-3">{{ $recipent->name }} {{ $recipent->last_name }}</p>
                </div>
                @endforeach
                @endif
            </div>
            <div class="row mt-3 mb-2">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <button class="w-100 rec-button">SUBMIT</button>

                </div>
                <div class="col-lg-4"></div>

            </div>
        </div>
    </div>

</div>

@endsection