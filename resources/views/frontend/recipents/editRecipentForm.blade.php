<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","Edit Recipient")
@section("content")
<div class="container-fluid bg-dash add-background">
    <div class="scroll-div recipent-div row-height">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form method="POST" action="{{ route('user.recipents.update-recipent') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                    <input type="hidden" id="country_code" name="country_code" value="">
                    <input type="hidden" id="postal_code_format" name="postal_code_format" value="{{ $recipient->postal_code_format }}">
                    <div class="bg-add">
                        <div class="row mt-4">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <div class="text-center">
                                    <label for="file">
                                        <img src="{{ asset($recipient->profile_image) }}" id="output" class="image-upload mb-2" style="border-radius: 100%" />
                                    </label>
                                    @if($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                    @endif
                                    <a class="mt-5 cl-white upload upload-web px-3">
                                        <label class="icon-upload" for="file">&nbsp;&nbsp;<span class="FranklinGotTRegCon">Upload Image</span></label>
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

                        <div class="row mt-4">
                            <div class="col-lg-12 mb-4">

                                @if($errors->has('name'))
                                <div class="error text-white">{{ $errors->first('name') }}</div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">First Name</span>
                                    </div>
                                    <input type="text" name="name" value="{{ $recipient->first_name }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>

                                @if($errors->has('last_name'))
                                <div class="error text-white">{{ $errors->first('last_name') }}</div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Last Name</span>
                                    </div>
                                    <input type="text" name="last_name" value="{{ $recipient->last_name }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>

                                @if($errors->has('email'))
                                <div class="error text-white">{{ $errors->first('email') }}</div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">EMAIL</span>
                                    </div>
                                    <input type="email" name="email" value="{{ $recipient->email }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" readonly />
                                </div>

                                <div class="col-12" id="show_phone_msg"></div>
                                <div class="input-group phone-area mb-3 recipent-phone">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">PHONE</span>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ $recipient->phone_number }}" class="form-control add-input" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" maxlength="15" onKeyup='addDashes(this)' required />
                                </div>

                                @if($errors->has('address'))
                                <div class="error text-white">{{ $errors->first('address') }}</div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 1</span>
                                    </div>
                                    <input type="text" name="address" value="{{ $recipient->address }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 2</span>
                                    </div>
                                    <input type="text" name="address_2" value="{{ $recipient->address_2 }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Optional" />
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Country</span>
                                    </div>
                                    <select id="country_id" name="country_id" class="form-control add-input" aria-describedby="basic-addon1" onChange="selectCountry()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                    <option value="">Select Country</option>
                                    @if(isset($countries))
                                    @foreach($countries as $key => $country)
                                    @if($country->id == $recipient->country_id)
                                    <option id="{{ $country->postal_code_format }}" value="{{ $country->id }}" selected>
                                        {{ $country->country_name }}
                                    </option>
                                    @else
                                    <option id="{{ $country->postal_code_format }}" value="{{ $country->id }}">
                                        {{ $country->country_name }}
                                    </option>
                                    @endif
                                    @endforeach
                                    @endif
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">State /
                                            Province</span>
                                    </div>
                                    <select id="state_province_id" name="state_province_id" class="form-control add-input" aria-describedby="basic-addon1" onChange="selectProvince()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                    @if(isset($provinces))
                                    @foreach($provinces as $key => $province)
                                    @if($province->id == $recipient->state_province_id)
                                    <option value="{{ $province->id }}" selected>
                                        {{ $province->name }}
                                    </option>
                                    @else
                                    <option value="{{ $province->id }}">
                                        {{ $province->name }}
                                    </option>
                                    @endif
                                    @endforeach
                                    @endif
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">City</span>
                                    </div>
                                    <select id="city_id" name="city_id" class="form-control add-input" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                    @if($recipient->city_name == 'Default City')
                                        <option value="{{ $recipient->city_id }}" selected>
                                            {{ $recipient->city_name }}
                                        </option>
                                    @else
                                        @if(isset($cities))
                                        @foreach($cities as $key => $city)
                                        @if($recipient->city_id == $city->id)
                                        <option value="{{ $recipient->city_id }}" selected>
                                            {{ $city->city_name }}
                                        </option>
                                        @else
                                        <option value="{{ $city->id }}">
                                            {{ $city->city_name }}
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    @endif
                                    </select>
                                </div>

                                <div class="col-12" id="show_postal_msg"></div>
                                <div class="input-group mb-3" id="zip_code">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Zip / Postal
                                            Code</span>
                                    </div>
                                    <input type="text" id="zip_postal_code" name="zip_postal_code" value="{{ $recipient->zip_postal_code }}" class="form-control add-input" aria-describedby="basic-addon1" placeholder="Required Field" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <h4 class="text-white">STATUS</h4>
                            </div>
                            <div class="d-flex">
                                @if($recipient->contact_status_id != '')
                                <label class="container-check label-add cl-white">{{ strtoupper($recipient->contact_title) }}
                                        <input type="checkbox" class="contact-status" id="contact_5" name="contact_status_id" value="{{ $recipient->contact_status_id }}" checked />
                                        <span class="checkmark add-check"></span>
                                    </label>
                                @endif
                                @if(isset($contact_status))
                                @foreach($contact_status as $key => $contact)
                                @php $id_name = 'contact_' . ++$key; @endphp
                                @if(!(in_array($contact->id, $user_contact)))
                                <label class="container-check label-add cl-white">{{ strtoupper($contact->contact_title) }}
                                        <input type="checkbox" class="contact-status" id="{{ $id_name }}" name="contact_status_id" value="{{ $contact->id }}" />
                                        <span class="checkmark add-check"></span>
                                    </label>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="col-12" id="show_status_msg"></div>

                            <h4 class="text-white mt-3 mb-3">EXISTING GROUP</h4>
                            <div class="d-flex" id="user_group">
                                @if(isset($groups))
                                @foreach($groups as $key => $group)
                                @php $id_name = 'group_' . ++$key; @endphp
                                <label class="container-check label-add cl-white">{{ strtoupper($group->group_title) }}
                                        @if($recipient->group_id == $group->id)
                                        <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id" value="{{ $group->id }}" onclick="selectGroup(this)" checked />
                                        @else
                                        <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id" value="{{ $group->id }}" onclick="selectGroup(this)" />
                                        @endif
                                        <span class="checkmark add-check"></span>
                                    </label>
                                @endforeach
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">GROUP</span>
                                </div>
                                <input type="text" id="group_title" name="group_title" class="form-control add-input" placeholder="Enter Here.." aria-describedby="basic-addon1" />
                                <span data-bs-toggle="modal" data-bs-target="#confirmModal" class="recipent-add-btn
                          btn 
                          bg-primary  
                          schedule-div recipent-schedule
                        ">
                                    <span class="schedule text-black" onclick="addGroup()">ADD</span>
                                </span>
                            </div>

                        </div>
                        <div class="row padding-add padd-bottom">
                            <div class="col-lg-12 text-center mt-4 mb-4">
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#confirmModal" class="recipent-mob-btn
                            btn
                            w-100
                            bg-primary 
                            m-auto
                            text-center
                            py-3
                            mt-3
                            schedule-div
                          ">
                                    <span class="schedule mt-3 text-black">UPDATE RECIPENT</span>
                                </button>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{!! asset('/public/build/js/intlTelInput.js') !!}"></script>
<script>
    var input = document.querySelector("#phone");
    var country_code = '<?= $recipient->country_code ?>';
    if (country_code.length == 0) {
        country_code = "pk";
    }
    window.intlTelInput(input, {
        initialCountry: country_code,
        utilsScript: "{!! asset('/public/build/js/utils.js') !!}",
    });
</script>
@endsection

<script type="text/javascript">
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
                } else {
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
                }
            }
        });

        postal_code_format.value = option.id;
        var required_field = 'Required Field';
        var validity = '';
        var zip_input = '<div class="input-group-append"><span class="input-group-text add-label" id="basic-addon2">Zip / Postal Code</span></div><input type="text" id="zip_postal_code" name="zip_postal_code" value="" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity(' + required_field + ')" oninput="setCustomValidity(' + validity + ')" required />';
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

    function selectGroup(current) {
        var inputs = document.querySelectorAll('.user-group');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
        }
        current.checked = true;
    }

    function addGroup() {
        var user_input = document.getElementById('group_title');
        // var option = select.options[select.selectedIndex];
        var group_title = user_input.value;

        $.ajax({
            url: 'add-group/' + group_title,
            type: 'get',
            success: function(response) {
                if (response != null) {
                    user_input.value = '';
                    var id = response.id;
                    var group_title = response.group_title;
                    group_title = group_title.toUpperCase();
                    var group_id = 'new_group_' + id;
                    var new_group =
                        '<div class="col-lg-4 col-4"><label class="container-check label-add cl-white">' +
                        group_title + '<input type="checkbox" class="user-group" id="' + group_id +
                        '" name="group_id" value="' + id +
                        '" onclick="selectGroup(this)" /><span class="checkmark add-check"></span></label></div>';
                    $("#user_group").append(new_group);
                }
            }
        });
    }

    function validateForm() {
        var phone_code = document.getElementById('country_code');
        var phone = document.getElementById('phone');
        var phone_number = phone.value;
        var phone_placeholder = phone.placeholder;
        var phone_msg = '<span class="cl-white">Phone number is incomplete!</span>';
        var selected_flag = document.querySelector('.iti__selected-flag');
        var get_code = selected_flag.getAttribute('aria-activedescendant');
        var country_code = '';
        const myArray = get_code.split("-");
        var word = myArray[1];
        var word_length = myArray.length;
        var word_index = word_length - 1;
        var inputs = document.querySelectorAll('.contact-status');
        var status_msg = '<span class="cl-white">Please select only one status!</span>';
        var selected_status = 0;

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
                $("#show_phone_msg").append('<span class="cl-white">Phone number is not valid!!</span>');
                return false;
            }
        }
        if (phone_number.length != phone_placeholder.length) {
            $('#show_phone_msg').empty();
            $("#show_phone_msg").append(phone_msg);
            return false;
        }
        $('#show_phone_msg').empty();

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked == true) {
                selected_status++;
            }
        }
        if (selected_status > 1) {
            $('#show_status_msg').empty();
            $("#show_status_msg").append(status_msg);
            return false;
        }

        var postal_code_format = document.getElementById('postal_code_format').value;
        if (postal_code_format != 00000 || postal_code_format != NULL) {
            var zip_postal_code = document.getElementById('zip_postal_code').value;
            var postal_msg = '<span class="cl-white">Format not matched! required format is ' + postal_code_format + '</span>';
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