<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","Register")
@section("content")
<div class="container-fluid payment-back-mob accont-padding-top">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="mt-4 account-head text-center text-white">CREATE AN ACCOUNT</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <img src="{{ asset('/public/media/image/default.png') }}" id="output" class="image-upload mb-2" style="border-radius: 100%" />
                                @if($errors->has('image'))
                                <div class="error text-white">{{ $errors->first('image') }}</div>
                                @endif
                                <a class="mt-5 cl-white upload upload-web px-3">
                                    <label class="icon-upload" for="file">&nbsp;&nbsp;<span class="upload-font">Upload Image</span></label>
                                    <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;">
                                </a>


                                <script>
                                    var loadFile = function(event) {
                                        var image = document.getElementById('output');
                                        image.src = URL.createObjectURL(event.target.files[0]);
                                    };
                                </script>

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
                                <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('name'))
                            <div class="error text-white">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Last Name</span>
                                </div>
                                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('last_name'))
                            <div class="error text-white">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Email</span>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('email'))
                            <div class="error text-white">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <script src="{!! asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') !!}"></script>
                        <script src="{!! asset('https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js') !!}"></script>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3" id="phone_div">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Phone Number</span>
                                </div>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" onfocus="myFunction(this)" required />
                                <div class="col-12 text-white" id="show_phone_msg"></div>
                            </div>
                            @if($errors->has('phone'))
                            <div class="error text-white">{{ $errors->first('phone') }}</div>
                            @endif
                            <div style="margin-top: -15;" id="show_phone_msg"></div>
                        </div>
                        <script>
                            $(":input").inputmask();
                        </script>
                        <div class="col-lg-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Address</span>
                                </div>
                                <input id="address" name="address" type="text" value="{{ old('address') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('address'))
                            <div class="error text-white">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Password</span>
                                </div>
                                <input id="password" name="password" type="password" value="{{ old('password') }}" class="form-control text-end" old autocomplete="new-password" aria-describedby="basic-addon1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Should be at least 8 characters with one upper, one lower and one number')" oninput="setCustomValidity('')" required />
                                <div class="input-group-prepend">
                                    <span class="input-group-text eye-pass-reg" id="basic-addon1"><img style="height: 20px; width: 20px;" src="{{ asset('/public/assets/images/eye.png') }}" onclick="showPassword()" /></span>
                                </div>
                            </div>
                            @if($errors->has('password'))
                            <div class="error text-white">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Confirm Password</span>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" class="form-control text-end" autocomplete="new-password" aria-describedby="basic-addon1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Should be at least 8 characters with one upper, one lower and one number')" oninput="setCustomValidity('')" required />
                                <div class="input-group-prepend">
                                    <span class="input-group-text eye-pass-reg" id="basic-addon1"><img style="height: 20px; width: 20px;" src="{{ asset('/public/assets/images/eye.png') }}" onclick="showConfirmPassword()" /></span>
                                </div>
                                <div class="col-12 text-white" id="show_confirm_pass_msg"></div>
                            </div>
                            @if($errors->has('password_confirmation'))
                            <div class="error text-white">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Country</span>
                                </div>
                                <select id="country_id" name="country_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectCountry()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <option value="">Select Country</option>
                                @if(isset($countries))
                                @foreach($countries as $key => $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                            @if($errors->has('country'))
                            <div class="error text-white">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">State / Province</span>
                                </div>
                                <select id="state_province_id" name="state_province_id" class="form-control text-end" aria-describedby="basic-addon1" onChange="selectProvince()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <option value="">Select State / Province</option>
                                </select>
                            </div>
                            @if($errors->has('state_province_id'))
                            <div class="error text-white">{{ $errors->first('state_province_id') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">City</span>
                                </div>
                                <select id="city_id" name="city_id" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <option value="">Select City</option>
                                </select>
                            </div>
                            @if($errors->has('city_id'))
                            <div class="error text-white">{{ $errors->first('city_id') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Zip / Postal Code</span>
                                </div>
                                <input id="zip_postal_code" name="zip_postal_code" type="text" value="{{ old('zip_postal_code') }}" class="form-control text-end" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('zip_postal_code'))
                            <div class="error text-white">{{ $errors->first('zip_postal_code') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6 text-center mb-5">

                            <div class=" btn btn-contin w-100 bg-primary m-auto">
                                <button type="submit" class="btn btn-primary p-1" style="font-family: FranklinGotItcTEEMedCon !important; font-size: 16px; color:black; background:none; border:10px; width:100%">
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
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: "off",
        // dropdownContainer: document.body,
        // excludeCountries: ["us"],
        // formatOnDisplay: false,
        // geoIpLookup: function(callback) {
        //     $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //     var countryCode = (resp && resp.country) ? resp.country : "";
        //     callback(countryCode);
        //     });
        // },
        // hiddenInput: "full_number",
        // initialCountry: "auto",
        // localizedCountries: { 'de': 'Deutschland' },
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        // preferredCountries: ['cn', 'jp'],
        // separateDialCode: true,
        utilsScript: "{!! asset('/public/build/js/utils.js') !!}",
    });
</script>
@endsection

<script type="text/javascript">
    function myFunction() {
        var phone = document.getElementById('phone');
        var phone_placeholder = phone.placeholder;
        var phone_format = '';
        for (var i = 0; i < phone_placeholder.length; i++) {
            var check_placeholder = parseInt(phone_placeholder[i]);
            if ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9].includes(check_placeholder)) {
                phone_format = phone_format + '9';
            }
            else {
                phone_format = phone_format + phone_placeholder[i];
            }
        }
        var set_format = "'mask': '" + phone_format + "'";
        phone.setAttribute('data-inputmask', set_format);
    }

    function showPassword() {
        var pass = document.getElementById("password");
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }

    function showConfirmPassword() {
        var confirm_pass = document.getElementById("password_confirmation");
        if (confirm_pass.type === "password") {
            confirm_pass.type = "text";
        } else {
            confirm_pass.type = "password";
        }
    }

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

    function validateForm() {
        var pass = document.getElementById("password").value;
        var password_confirmation = document.getElementById("password_confirmation").value;
        var phone = document.getElementById('phone');
        var phone_number = phone.value;
        var phone_placeholder = phone.placeholder;
        var phone_msg = 'Required format is '+ phone_placeholder;
        var selected_flag = document.querySelector('.iti__selected-flag');
        var get_code = selected_flag.getAttribute('aria-activedescendant');
        var country_code = '';
        const myArray = get_code.split("-");
        var word = myArray[1];
        var word_length = myArray.length;
        var word_index = word_length - 1;
        if (myArray[word_index] == 'preferred') {
            country_code = myArray[--word_index];
        }
        else {
            country_code = myArray[word_index];
        }
        if (phone_number.length == phone_placeholder.length) {
            var number_special_char = 0;
            var placeholder_special_char = 0;
            for (var i = 0; i < phone_number.length; i++) {
                var check_number = parseInt(phone_number[i]);
                var check_placeholder = parseInt(phone_placeholder[i]);
                if (!([0, 1, 2, 3, 4, 5, 6, 7, 8, 9].includes(check_number))) {
                    number_special_char++;
                    if (phone_number[i] != phone_placeholder[i]) {
                        $('#show_phone_msg').empty();
                        $("#show_phone_msg").append(phone_msg);
                        return false;
                    }
                }
                if (!([0, 1, 2, 3, 4, 5, 6, 7, 8, 9].includes(check_placeholder))) {
                    placeholder_special_char++
                }
            }
            if(number_special_char != placeholder_special_char) {
                $('#show_phone_msg').empty();
                $("#show_phone_msg").append(phone_msg);
                return false;
            }
            else {
                $('#show_phone_msg').empty();
            }
        }
        else {
            $('#show_phone_msg').empty();
            $("#show_phone_msg").append(phone_msg);
            return false;
        }
        $('#show_confirm_pass_msg').empty();
        if (pass != password_confirmation) {
            $("#show_confirm_pass_msg").append('Password & confirm password are not matched!');
            return false;
        }
    }
</script>