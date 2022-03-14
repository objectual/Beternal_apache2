@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")
<div class="container-fluid bg-dash add-background">
    <div class="scroll-div recipent-div">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="bg-add">

                    <div class="row mt-4">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <img src="{{ asset('/public/media/image/default.png') }}" id="output"
                                    class="image-upload mb-2" style="border-radius: 100%" />
                                @if($errors->has('image'))
                                <div class="error">{{ $errors->first('image') }}</div>
                                @endif
                                <a class="mt-5 cl-white upload upload-web px-3">
                                    <label class="icon-upload" for="file">&nbsp;&nbsp;Upload Image</label>
                                    <input type="file" accept="image/*" name="image" id="file"
                                        onchange="loadFile(event)" style="display: none;">
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
                                    <span class="input-group-text add-label" id="basic-addon2">Full Name</span>
                                </div>
                                <input type="text" name="name" class="form-control add-input"
                                    placeholder="Required Field" aria-describedby="basic-addon1" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">Last Name</span>
                                </div>
                                <input type="text" name="last_name" class="form-control add-input"
                                    placeholder="Required Field" aria-describedby="basic-addon1" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">EMAIL</span>
                                </div>
                                <input type="email" name="email" class="form-control add-input"
                                    placeholder="Required Field" aria-describedby="basic-addon1" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">PHONE</span>
                                </div>
                                <input type="text" class="form-control add-input" placeholder="Required Field"
                                    aria-describedby="basic-addon1" />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">ADDRESS 1</span>
                                </div>
                                <input type="text" name="address" class="form-control add-input"
                                    placeholder="Required Field" aria-describedby="basic-addon1" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">ADDRESS 2</span>
                                </div>
                                <input type="text" name="address_2" class="form-control add-input"
                                    placeholder="Optional" aria-describedby="basic-addon1" required />
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">Country</span>
                                </div>
                                <select id="country_id" name="country_id" class="form-control add-input"
                                    aria-describedby="basic-addon1" onChange="selectCountry()" required />
                                <option value="">Select Country</option>
                                @if(isset($countries))
                                @foreach($countries as $key => $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">State / Province</span>
                                </div>
                                <select id="state_province_id" name="state_province_id" class="form-control add-input"
                                    aria-describedby="basic-addon1" onChange="selectProvince()" required />
                                <option value="">Select State / Province</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">City</span>
                                </div>
                                <select id="city_id" name="city_id" class="form-control add-input"
                                    aria-describedby="basic-addon1" required />
                                <option value="">Select City</option>
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text add-label" id="basic-addon2">Zip / Postal Code</span>
                                </div>
                                <input type="text" class="form-control add-input" placeholder="Required Field"
                                    aria-describedby="basic-addon1" />
                            </div>
                            <h4 class="text-white">STATUS</h4>
                        </div>
                        <div class="row">
                            @if(isset($contact_status))
                            @foreach($contact_status as $key => $contact)
                            @php $id_name = 'contact_' . ++$key; @endphp
                            <div class="col-lg-4 col-6">
                                <label
                                    class="container-check label-add cl-white">{{ strtoupper($contact->contact_title) }}
                                    <input type="checkbox" class="contact-status" id="{{ $id_name }}"
                                        name="contact_status_id" value="{{ $contact->id }}"
                                        onclick="selectContact(this)" />
                                    <span class="checkmark add-check"></span>
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <h4 class="text-white mt-3 mb-3">EXISTING GROUP</h4>
                        @if(isset($groups))
                        @foreach($groups as $key => $group)
                        @php $id_name = 'group_' . ++$key; @endphp
                        <div class="col-lg-4 col-4">
                            <label class="container-check label-add cl-white">{{ strtoupper($group->group_title) }}
                                <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id"
                                    value="{{ $group->id }}" onclick="selectGroup(this)" />
                                <span class="checkmark add-check"></span>
                            </label>
                        </div>
                        @endforeach
                        @endif

                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text add-label" id="basic-addon2">GROUP</span>
                            </div>
                            <input type="text" class="form-control add-input"
                                placeholder="Dropdowm menu w/ custom field" aria-describedby="basic-addon1" />
                            <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="recipent-add-btn
                          btn 
                          bg-primary  
                          schedule-div
                        ">
                                <span class="schedule">ADD</span>
                            </button>
                        </div>

                    </div>
                    <div class="row padding-add padd-bottom">
                        <div class="col-lg-12 text-center mt-4 mb-4">
                            <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="recipent-mob-btn
                            btn
                            w-100
                            bg-primary 
                            m-auto
                            text-center
                            py-3
                            mt-3
                            schedule-div
                          ">
                                <span class="schedule mt-3">ADD RECIPENT</span>
                            </button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

function selectContact(current) {
    var inputs = document.querySelectorAll('.contact-status');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].checked = false;
    }
    current.checked = true;
}

function selectGroup(current) {
    alert(current.id)
    var inputs = document.querySelectorAll('.user-group');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].checked = false;
    }
    current.checked = true;
}
</script>