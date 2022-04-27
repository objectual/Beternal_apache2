@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")
<div class="container-fluid bg-dash add-background">
    <div class="scroll-div recipent-div">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form method="POST" action="{{ route('user.recipents.update-recipent') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="recipient_id" value="{{ $recipient->recipient_id }}">
                    <div class="bg-add">

                        <div class="row mt-4">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <div class="text-center">
                                    <img src="{{ asset($recipient->profile_image) }}" id="output" class="image-upload mb-2" style="border-radius: 100%" />
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
                                    <input type="text" name="name" value="{{ $recipient->first_name }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Last Name</span>
                                    </div>
                                    <input type="text" name="last_name" value="{{ $recipient->last_name }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">EMAIL</span>
                                    </div>
                                    <input type="email" name="email" value="{{ $recipient->email }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">PHONE</span>
                                    </div>
                                    <input type="text" name="phone" value="{{ $recipient->phone_number }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 1</span>
                                    </div>
                                    <input type="text" name="address" value="{{ $recipient->address }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">ADDRESS 2</span>
                                    </div>
                                    <input type="text" name="address_2" value="{{ $recipient->address_2 }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Country</span>
                                    </div>
                                    <input type="text" value="{{ $recipient->country_name }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">State /
                                            Province</span>
                                    </div>
                                    <input type="text" value="{{ $recipient->name }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">City</span>
                                    </div>
                                    <input type="text" value="{{ $recipient->city_name }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text add-label" id="basic-addon2">Zip / Postal
                                            Code</span>
                                    </div>
                                    <input type="text" name="zip_postal_code" value="{{ $recipient->zip_postal_code }}" class="form-control add-input" aria-describedby="basic-addon1" readonly />
                                </div>
                                <h4 class="text-white">STATUS</h4>
                            </div>
                            <div class="row">
                                @if($recipient->contact_status_id != '')
                                <div class="col-lg-4 col-6">
                                    <label class="container-check label-add cl-white">{{ strtoupper($recipient->contact_title) }}
                                        <input type="checkbox" class="contact-status" id="contact_5" name="contact_status_id" value="{{ $recipient->contact_status_id }}" onclick="selectContact(this)" checked />
                                        <span class="checkmark add-check"></span>
                                    </label>
                                </div>
                                @endif
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
                            <h4 class="text-white mt-3 mb-3">EXISTING GROUP</h4>
                            <div class="row" id="user_group">
                                @if(isset($groups))
                                @foreach($groups as $key => $group)
                                @php $id_name = 'group_' . ++$key; @endphp
                                <div class="col-lg-4 col-4">
                                    <label class="container-check label-add cl-white">{{ strtoupper($group->group_title) }}
                                        @if($recipient->group_id == $group->id)
                                        <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id" value="{{ $group->id }}" onclick="selectGroup(this)" checked />
                                        @else
                                        <input type="checkbox" class="user-group" id="{{ $id_name }}" name="group_id" value="{{ $group->id }}" onclick="selectGroup(this)" />
                                        @endif
                                        <span class="checkmark add-check"></span>
                                    </label>
                                </div>
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
                                    <span class="schedule" onclick="addGroup()">ADD</span>
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
                                    <span class="schedule mt-3">UPDATE RECIPENT</span>
                                </button>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
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
                    var group_title = group_title.toUpperCase();
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
</script>