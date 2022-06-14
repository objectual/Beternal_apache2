<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","Register")
@section("content")
<div class="container-fluid payment-back-mob accont-padding-top edit-register">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" id="country_code" name="country_code" value="">
                    <input type="hidden" id="postal_code_format" name="postal_code_format" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="mt-4 account-head text-center text-white">CREATE AN ACCOUNT</h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <label for="file"><img src="{{ asset('/public/media/image/default.png') }}" id="output" class="image-upload mb-2" style="border-radius: 100%" /></label>
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
                                <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
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
                                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
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
                                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                            </div>
                            @if($errors->has('email'))
                            <div class="error text-white">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group phone-area mb-3" id="phone_div">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Phone </span>
                                </div>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" maxlength="15" onKeyup='addDashes(this)' required />
                                <div class="col-12 text-white" id="show_phone_msg"></div>
                            </div>
                            @if($errors->has('phone'))
                            <div class="error text-white">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label" id="basic-addon2">Address</span>
                                </div>
                                <input id="address" name="address" type="text" value="{{ old('address') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
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
                                <input id="password" name="password" type="password" value="{{ old('password') }}" class="form-control text-start" old autocomplete="new-password" aria-describedby="basic-addon1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Should be at least 8 characters with one upper, one lower and one number')" oninput="setCustomValidity('')" required />
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
                                <input id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" class="form-control text-start" autocomplete="new-password" aria-describedby="basic-addon1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Should be at least 8 characters with one upper, one lower and one number')" oninput="setCustomValidity('')" required />
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
                                <select id="country_id" name="country_id" class="form-control text-start" aria-describedby="basic-addon1" onChange="selectCountry()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <option value="">Select Country</option>
                                @if(isset($countries))
                                @foreach($countries as $key => $country)
                                <option id="{{ $country->postal_code_format }}" value="{{ $country->id }}">
                                    {{ $country->country_name }}
                                </option>
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
                                <select id="state_province_id" name="state_province_id" class="form-control text-start" aria-describedby="basic-addon1" onChange="selectProvince()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
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
                                <select id="city_id" name="city_id" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <option value="">Select City</option>
                                </select>
                            </div>
                            @if($errors->has('city_id'))
                            <div class="error text-white">{{ $errors->first('city_id') }}</div>
                            @endif
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="input-group mb-3" id="zip_code">
                                <div class="input-group-append">
                                    <span class="input-group-text input-back account-label zip" id="basic-addon2">Zip / Postal Code</span>
                                </div>
                                <input id="zip_postal_code" name="zip_postal_code" type="text" value="{{ old('zip_postal_code') }}" class="form-control text-start" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                <div class="col-12 text-white" id="show_postal_msg"></div>
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
    // function myFunction() {
    //     var phone = document.getElementById('phone');
    //     var phone_placeholder = phone.placeholder;
    //     var phone_format = '';
    //     for (var i = 0; i < phone_placeholder.length; i++) {
    //         var check_placeholder = parseInt(phone_placeholder[i]);
    //         if ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9].includes(check_placeholder)) {
    //             phone_format = phone_format + '0';
    //         } else {
    //             phone_format = phone_format + phone_placeholder[i];
    //         }
    //     }
    //     var set_format = "'mask': '" + phone_format + "'";
    //     phone.setAttribute('data-inputmask', set_format);
    // }

    window.addDashes = function addDashes(f) {
        let unicode = event.keyCode;
        if (unicode != 8) {
            var phone = document.getElementById('phone');
            var phone_placeholder = phone.placeholder;
            const check_integer = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
            const index_of_char = [];
            const count_n = [];

            // var char_1 = '';
            // var char_2 = '';
            // var char_3 = '';
            // var char_4 = '';
            // var char_5 = '';
            // var num_1 = '';
            // var num_2 = '';
            // var num_3 = '';
            // var num_4 = '';
            // var num_5 = '';
            // var a = 1;
            // var b = 1;
            // var x = 0;
            // var check_length = phone_placeholder.length - 1;
            // for (var i = 0; i < phone_placeholder.length; i++) {
            //     var check_placeholder = parseInt(phone_placeholder[i]);
            //     if (check_integer.includes(check_placeholder)) {
            //         x++;
            //         if (i == check_length) {
            //             count_n.push(x);
            //         }
            //     } else {
            //         index_of_char.push(i);
            //         count_n.push(x);
            //         x = 0;
            //         if (a == 1) {
            //             char_1 = phone_placeholder[i];
            //         }
            //         if (a == 2) {
            //             char_2 = phone_placeholder[i];
            //         }
            //         if (a == 3) {
            //             char_3 = phone_placeholder[i];
            //         }
            //         if (a == 4) {
            //             char_4 = phone_placeholder[i];
            //         }
            //         if (a == 5) {
            //             char_5 = phone_placeholder[i];
            //         }
            //         a++;
            //     }
            // }
            // for (var j = 0; j < count_n.length; j++) {
            //     if (b == 1) {
            //         num_1 = count_n[j];
            //     }
            //     if (b == 2) {
            //         num_2 = count_n[j];
            //     }
            //     if (b == 3) {
            //         num_3 = count_n[j];
            //     }
            //     if (b == 4) {
            //         num_4 = count_n[j];
            //     }
            //     if (b == 5) {
            //         num_5 = count_n[j];
            //     }
            //     b++;
            // }
            // var r = /(\D+)/g,
            //     npa = '',
            //     nxx = '',
            //     nxy = '',
            //     nxz = '',
            //     last4 = '';
            // f.value = f.value.replace(r, '');
            // npa = f.value.substr(0, num_1);
            // nxx = f.value.substr(num_1, num_2);
            // nxy = f.value.substr(num_1 + num_2, num_3);
            // nxz = f.value.substr(num_2 + num_3, num_4);
            // last4 = f.value.substr(num_3 + num_4, num_5);
            // f.value = npa + char_1 + nxx + char_2 + nxy + char_3 + nxz + char_4 + last4;

            phone.setAttribute('maxlength', phone_placeholder.length);
            if (phone.value.length <= phone_placeholder.length) {
                if (phone.value.length < 2) {
                    var first_index = parseInt(phone_placeholder[0]);
                    var first_integer = 0;
                    if (check_integer.includes(first_index)) {
                        first_integer = 1;
                    }
                    if (first_integer == 0) {
                        var first_char = '';
                        first_char = phone_placeholder[0];
                        first_char = first_char + phone.value;
                        phone.value = first_char;
                    }
                }
                if (phone.value.length < phone_placeholder.length) {
                    var len = phone.value.length;
                    var check_placeholder = parseInt(phone_placeholder[len]);
                    if (!(check_integer.includes(check_placeholder))) {
                        var phone_format = '';
                        phone_format = phone.value;
                        phone_format = phone_format + phone_placeholder[len];
                        phone.value = phone_format;
                    }
                }
                if (phone.value.length < phone_placeholder.length) {
                    var len_2 = phone.value.length;
                    var check_placeholder_2 = parseInt(phone_placeholder[len_2]);
                    if (!(check_integer.includes(check_placeholder_2))) {
                        var phone_format_2 = '';
                        phone_format_2 = phone.value;
                        phone_format_2 = phone_format_2 + phone_placeholder[len_2];
                        phone.value = phone_format_2;
                    }
                }
            }
        }
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
        var postal_code_format = document.getElementById('postal_code_format');

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

        postal_code_format.value = option.id;
        var required_field = 'Required Field';
        var validity = '';
        var zip_input = '<div class="input-group-append"><span class="input-group-text add-label zip" id="basic-addon2">Zip / Postal Code</span></div><input type="text" id="zip_postal_code" name="zip_postal_code" value="" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity(' + required_field + ')" oninput="setCustomValidity(' + validity + ')" required /><div class="col-12 text-white" id="show_postal_msg"></div>';
        $('#show_postal_msg').empty();
        $('#zip_code').empty();
        $('#zip_code').append(zip_input);
        if (option.id == 00000 || option.id == NULL) {
            $('#show_postal_msg').empty();
            $('#zip_code').empty();
        }
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
                } else {
                    var o = new Option(option.text, 0);
                    $("#city_id").append(o);
                }
            }
        });
    }

    function validateForm() {
        var phone_code = document.getElementById('country_code');
        var pass = document.getElementById("password").value;
        var password_confirmation = document.getElementById("password_confirmation").value;
        var phone = document.getElementById('phone');
        var phone_number = phone.value;
        var phone_placeholder = phone.placeholder;
        var selected_flag = document.querySelector('.iti__selected-flag');
        var get_code = selected_flag.getAttribute('aria-activedescendant');
        var country_code = '';
        const myArray = get_code.split("-");
        var word = myArray[1];
        var word_length = myArray.length;
        var word_index = word_length - 1;
        if (myArray[word_index] == 'preferred') {
            country_code = myArray[--word_index];
        } else {
            country_code = myArray[word_index];
        }
        phone_code.value = country_code;

        const check_alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        for (var i = 0; i < phone_number.length; i++) {
            if (check_alpha.includes(phone_number[i])) {
                $('#show_phone_msg').empty();
                $("#show_phone_msg").append('Phone number is not valid!');
                return false;
            }
        }
        if (phone_number.length != phone_placeholder.length) {
            $('#show_phone_msg').empty();
            $("#show_phone_msg").append('Phone number is incomplete!');
            return false;
        }

        $('#show_confirm_pass_msg').empty();
        if (pass != password_confirmation) {
            $("#show_confirm_pass_msg").append('Password & confirm password are not matched!');
            return false;
        }

        var postal_code_format = document.getElementById('postal_code_format').value;
        if (postal_code_format != 00000 || postal_code_format != NULL) {
            var zip_postal_code = document.getElementById('zip_postal_code').value;
            var postal_msg = 'Format not matched! required format is ' + postal_code_format;
            if (postal_code_format.length == zip_postal_code.length) {
                for (var i = 0; i < zip_postal_code.length; i++) {
                    var check_number_postal = parseInt(zip_postal_code[i]);
                    var check_postal_format = parseInt(postal_code_format[i]);
                    const check_integer = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                    const alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                    if (check_integer.includes(check_postal_format)) {
                        if (!(check_integer.includes(check_number_postal))) {
                            $('#show_postal_msg').empty();
                            $("#show_postal_msg").append(postal_msg);
                            return false;
                        }
                    } else if (alphabet.includes(postal_code_format[i])) {
                        if (!(alphabet.includes(zip_postal_code[i]))) {
                            $('#show_postal_msg').empty();
                            $("#show_postal_msg").append(postal_msg);
                            return false;
                        }
                    } else if (!(check_integer.includes(check_postal_format)) && !(alphabet.includes(postal_code_format[i]))) {
                        if (zip_postal_code[i] != postal_code_format[i]) {
                            $('#show_postal_msg').empty();
                            $("#show_postal_msg").append(postal_msg);
                            return false;
                        }
                    }
                }
                $('#show_postal_msg').empty();
            } else {
                $('#show_postal_msg').empty();
                $("#show_postal_msg").append(postal_msg);
                return false;
            }
        }
        return true;
    }
</script>