<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","My Profile Edit")
@section("content")

<div class="container-fluid payment-back-mob accont-padding-top">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form method="POST" action="{{route('user.profile.update')}}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                    @if(Session()->has('update'))
                    <br>
                    <div class="alert alert-info" role="alert" style="font-size: 18px; height: 45px; padding-left:250px;">
                        {{Session::get('update')}}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="mt-4 account-head text-center text-white">Edit AN ACCOUNT</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                {{-- <img src="./images/recipent.png" class="image-upload mb-2" />s --}}
                                <img src="@if(Auth::user()->profile_image){{asset( Auth::user()->profile_image) }}@else{{ asset('/assets/media/image/default.png') }}@endif" id="output" value="{{ Auth::user()->image }}" class="image-upload mb-2" style="border-radius: 100%" />
                                <a class="mt-5 cl-white upload upload-web px-3">
                                    <label class="icon-upload" for="file">&nbsp;&nbsp;<span class="upload-font">Upload Image</span></label>
                                    <input type="file" accept="image/*" name="image" id="file" value="{{ Auth::user()->image }}" onchange="loadFile(event)" style="display: none;">
                                </a>

                                <script>
                                    var loadFile = function(event) {
                                        var image = document.getElementById('output');
                                        image.src = URL.createObjectURL(event.target.files[0]);
                                    };
                                </script>
                                @if($errors->has('image'))
                                <div class="error">{{ $errors->first('image') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row mt-2 row-height">
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">First Name</span>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') ?? $user[0]->name }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Last Name</span>
                                </div>
                                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') ?? $user[0]->last_name }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('last_name'))
                                <div class="error">{{ $errors->first('last_name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Email</span>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') ?? $user[0]->email }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Phone Number</span>
                                </div>
                                <input id="phone" name="phone" type="text" value="{{ old('phone_number') ?? $user[0]->phone_number }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('phone_number'))
                                <div class="error">{{ $errors->first('phone_number') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-lg-3"></div> -->
                        <div class="col-lg-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Address</span>
                                </div>
                                <input id="address" name="address" type="text" value="{{ old('address') ?? $user[0]->address }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="col-lg-3"></div> -->
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Password</span>
                                </div>
                                <input id="password" name="password" type="password" value="{{ old('password') }}" class="form-control text-end" old autocomplete="new-password" aria-describedby="basic-addon1" />
                                @if($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Confirm Password</span>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" class="form-control text-end" autocomplete="new-password" aria-describedby="basic-addon1" />
                                @if($errors->has('password_confirmation'))
                                <div class="error">{{ $errors->first('password_confirmation') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Country</span>
                                </div>
                                <select id="country_id" name="country_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectCountry()" required />
                                <option value="{{ $user[0]->country_id }}" selected>{{ $user[0]->country_name }}</option>
                                @if(isset($countries))
                                @foreach($countries as $key => $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                                @endif
                                </select>
                                @if($errors->has('country'))
                                <div class="error">{{ $errors->first('country') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">State / Province</span>
                                </div>
                                <select id="state_province_id" name="state_province_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectProvince()" required />
                                <option value="{{ $user[0]->state_province_id }}" selected>{{ $user[0]->province_name }}</option>
                                @if(isset($countries))
                                @foreach($provinces as $key => $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                                @endif
                                </select>
                                @if($errors->has('state_province_id'))
                                <div class="error">{{ $errors->first('state_province_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">City</span>
                                </div>
                                <select id="city_id" name="city_id" class="form-control text-end" aria-describedby="basic-addon1" required />
                                <option value="{{ $user[0]->city_id }}">{{ $user[0]->city_name }}</option>
                                @if(isset($cities))
                                @foreach($cities as $key => $city)
                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                @endforeach
                                @endif
                                </select>
                                @if($errors->has('city_id'))
                                <div class="error">{{ $errors->first('city_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Zip / Postal Code</span>
                                </div>
                                <input id="zip_postal_code" name="zip_postal_code" type="text" value="{{ old('zip_postal_code') ?? $user[0]->zip_postal_code }}" class="form-control text-end" aria-describedby="basic-addon1" required />
                                @if($errors->has('zip_postal_code'))
                                <div class="error">{{ $errors->first('zip_postal_code') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6 text-center mb-5">

                            <div class=" btn btn-contin w-100 bg-primary m-auto">
                                <button type="submit" class="btn btn-primary p-1" style="font-size: 12px; color:black; background:none; border:10px; width:100%">
                                    {{ __('CONTINUE') }}
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                    </div>
            </div>
            </form>
            <div class="col-lg-3"></div>
        </div>
    </div>
</div>

<script src="{!! asset('/public/build/js/intlTelInput.js') !!}"></script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        utilsScript: "{!! asset('/public/build/js/utils.js') !!}",
    });
</script>
@endsection

<script type="text/javascript">
    function selectCountry() {
        var select = document.getElementById('country_id');
        var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'provinces/' + id,
            type: 'get',
            // dataType: 'json',
            success: function(response) {
                var len = 0;
                $('#state_province_id').empty();
                $('#city_id').empty();
                if (response != null) {
                    len = response.length;
                }
                if (len > 0) {
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
                    for (var i = 0; i < len; i++) {
                        var id = response[i].id;
                        var name = response[i].name;
                        var o = new Option(name, id);
                        $("#state_province_id").append(o);
                    }
                }
            }
        });
    }

    function selectProvince() {
        var select = document.getElementById('state_province_id');
        var option = select.options[select.selectedIndex];
        var id = option.value;

        $.ajax({
            url: 'cities/' + id,
            type: 'get',
            // dataType: 'json',
            success: function(response) {
                var len = 0;
                $('#city_id').empty();
                if (response != null) {
                    len = response.length;
                }
                if (len > 0) {
                    var o = new Option("Select City", "");
                    $("#city_id").append(o);
                    for (var i = 0; i < len; i++) {
                        var id = response[i].id;
                        var city_name = response[i].city_name;
                        var o = new Option(city_name, id);
                        $("#city_id").append(o);
                    }
                }
            }
        });
    }
</script>