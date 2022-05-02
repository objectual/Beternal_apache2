<link rel="stylesheet" type="text/css" href="{!! asset('/public/build/css/intlTelInput.css') !!}" />
@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")
<div class="container-fluid bg-dash add-background">
    <div class="scroll-div recipent-div">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form method="POST" action="{{ route('user.recipents.add-recipent') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    <div class="bg-add">

                        <div class="row mt-4">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <div class="text-center">
                                    <img src="{{ asset('/public/media/image/default.png') }}" id="output" class="image-upload mb-2" style="border-radius: 100%" />
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
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">First Name</span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Last Name</span>
                                    </div>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">EMAIL</span>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <div class="col-12" id="show_phone_msg"></div>
                                <div class="input-group mb-3 recipent-phone">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">PHONE</span>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control add-input" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 1</span>
                                    </div>
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 2</span>
                                    </div>
                                    <input type="text" name="address_2" class="form-control add-input" placeholder="Optional" aria-describedby="basic-addon1" />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Country</span>
                                    </div>
                                    <select id="country_id" name="country_id" class="form-control add-input" aria-describedby="basic-addon1" onChange="selectCountry()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                        <option value="">Select Country</option>
                                        @if(isset($countries))
                                        @foreach($countries as $key => $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->country_name }}
                                        </option>
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
                                        <option value="">Select State / Province</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">City</span>
                                    </div>
                                    <select id="city_id" name="city_id" class="form-control add-input" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                    <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Zip / Postal
                                            Code</span>
                                    </div>
                                    <input type="text" name="zip_postal_code" value="{{ old('zip_postal_code') }}" class="form-control add-input" placeholder="Required Field" aria-describedby="basic-addon1" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')" required />
                                </div>
                                <h4 class="text-white">STATUS</h4>
                            </div>
                            <div class="row">
                                @if(isset($contact_status))
                                @foreach($contact_status as $key => $contact)
                                @php $id_name = 'contact_' . ++$key; @endphp
                                @if(!(in_array($contact->id, $user_contact)))
                                <div class="col-lg-4 col-6">
                                    <label class="container-check label-add cl-white">{{ strtoupper($contact->contact_title) }}
                                        <input type="checkbox" class="contact-status" id="{{ $id_name }}" name="contact_status_id" value="{{ $contact->id }}" onclick="selectContact(this)" />
                                        <span class="checkmark add-check"></span>
                                    </label>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <h4 class="text-white mt-3 mb-3">GROUPS</h4>
                            <div class="row" id="user_group">
                                @if(isset($groups))
                                @foreach($groups as $key => $group)
                                @php $id_name = 'group_' . ++$key; @endphp
                                <div class="col-lg-4 col-4">
                                    <label class="container-check label-add cl-white">{{ strtoupper($group->group_title) }}
                                        <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id" value="{{ $group->id }}" onclick="selectGroup(this)" />
                                        <span class="checkmark add-check"></span>
                                    </label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="col-12" id="show_group_msg"></div>

                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">ADD GROUP</span>
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
                                    <span class="schedule mt-3 text-black">ADD</span>
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
                } else {
                    var default_province = new Option("Select State / Province", "");
                    var default_city = new Option("Select City", "");
                    $("#state_province_id").append(default_province);
                    $("#city_id").append(default_city);
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

    function selectContact(current) {
        var inputs = document.querySelectorAll('.contact-status');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
        }
        current.checked = true;
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
        var phone = document.getElementById('phone');
        var inputs = document.querySelectorAll('.user-group');
        var phone_number = phone.value;
        var phone_placeholder = phone.placeholder;
        var phone_msg = '<span class="cl-white">Format not matched! required format is '+ phone_placeholder +'</span>';
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
        var selected = 0;
        var group_msg = '<span class="cl-white">Please select atleast one group!</span>';
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked == true) {
                selected = 1;
                i = inputs.length;
            }
        }
        if (selected == 0) {
            $('#show_group_msg').empty();
            $("#show_group_msg").append(group_msg);
            return false;
        }
        return true;
    }
</script>