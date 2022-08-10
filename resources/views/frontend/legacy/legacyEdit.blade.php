@extends("frontend.layouts.layout")
@section("title","Capture Image")
@section("content")
@php $base_url = url(''); $user_recipient = array(); $user_group = array(); @endphp
@if(!$get_legacy->isEmpty())
    @if($get_legacy[0]->all_recipient != null) {
        @foreach($get_legacy[0]->all_recipient as $recipent) {
            @php array_push($user_recipient, $recipent->recipient_id); @endphp
        @endforeach
    @endif
    @if($get_legacy[0]->all_group != null) {
        @foreach($get_legacy[0]->all_group as $group) {
            @php array_push($user_group, $group->group_id); @endphp
        @endforeach
    @endif
@endif
<div class="container-fluid bg-create pb-4 h-auto upgrade-back">
    <div class="scroll-div h-auto">
        @if(!$get_legacy->isEmpty())
        <form method="POST" action="{{ route('user.legacy-update') }}" enctype="multipart/form-data" onsubmit="return validateForm(this)">
            @csrf
            <input type="hidden" name="legacy_id" value="{{ $get_legacy[0]->id }}">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            @if($get_legacy[0]->type == 'photo')
                                <picture id="ban_image" class="tv_image"><img src="{{ asset( $file_path.$get_legacy[0]->file_name )}}" type="image" height="500" width="720" /></picture>
                            @elseif($get_legacy[0]->type == 'video')
                                @php
                                    $format = explode(".", $get_legacy[0]->file_name);
                                    $ios = '#t=0.001';
                                    if ($format[1] == 'mov') {
                                        $set_format = 'video/mp4';
                                    } else {
                                        $set_format = 'video/'.$format[1];
                                    }
                                @endphp
                                <video id="" class="tv_video" controls><source src="{{ asset( $file_path.$get_legacy[0]->file_name.$ios )}}" type="{{ $set_format }}" /></video>
                            @elseif($get_legacy[0]->type == 'audio')
                                <audio id="ban_audio" class="tv_audio mt-4" controls><source src="{{ asset( $file_path.$get_legacy[0]->file_name )}}" type="audio/mp3" /></audio>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="mb-3 w-100">
                            <label for="photo_title" class="form-label text-white">Photo Title</label>
                            <input type="text" id="title" name="title" value="{{ $get_legacy[0]->title }}" class="form-control capture-form" placeholder="Title Here" required>
                            <div class="col-12" id="show_title_msg"></div>
                        </div>
                        <div class="mb-3  w-100">
                            <label for="description" class="form-label text-white">Description</label>
                            <textarea class="form-control capture-form" id="description" name="description" placeholder="Description Here" required>{{ $get_legacy[0]->description }}</textarea>
                            <div class="col-12" id="show_description_msg"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 w-100">
                            <div class="">
                                <div class="input-group">
                                    <input type="text" id="name" class="form-control search-input" placeholder="Search by Recipient's Name">
                                    <div class="input-group-append">
                                        <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" onclick="recipentByName(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white">Assign Recipient</p>
                        <div class="row mb-3" id="show_recipents">
                            @if(isset($user_recipents) && !$user_recipents->isEmpty())
                            <div class="col-lg-2 col-4 rec-images">
                                <img src="{{ asset('public/media/image/all-users.png') }}">
                                <p class="cl-white sel-text mt-3">
                                    <input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all recipient" onclick="selectAllRecipient(this)">
                                    All
                                </p>
                            </div>
                            @foreach($user_recipents as $key => $recipent)
                            <div class="col-lg-2 col-4 rec-images">
                                <img src="{{ asset($recipent->profile_image) }}">
                                <p class="cl-white sel-text mt-3">
                                    @if(in_array($recipent->recipient_id, $user_recipient))
                                    <input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="{{ $recipent->recipient_id }}" checked>
                                    {{ $recipent->name }}
                                    @else
                                    <input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="{{ $recipent->recipient_id }}">
                                    {{ $recipent->name }}
                                    @endif
                                </p>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <div class="">
                            <div class="input-group">
                                <input type="text" id="group_name" class="form-control search-input" placeholder="Search by Group's Name">
                                <div class="input-group-append">
                                    <img class="search-ico" src="{{ asset('public/assets/images/search-white.png')}}" onclick="groupByName(this)" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-white">Select Group</p>
                    <div id="show_groups">
                        @if(isset($groups) && !$groups->isEmpty())
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="all_group" name="all_group" value="all group" onclick="selectAllGroup(this)">
                            <label class="form-check-label text-white" for="group_id">All</label>
                        </div>
                        @foreach($groups as $key => $group)
                        <div class="form-check form-check-inline">
                            @if(in_array($group->id, $user_group))
                            <input class="form-check-input user-group" type="checkbox" name="group_id[]" value="{{ $group->id }}" checked>
                            <label class="form-check-label text-white" for="group_id">{{ strtoupper($group->group_title) }}</label>
                            @else
                            <input class="form-check-input user-group" type="checkbox" name="group_id[]" value="{{ $group->id }}">
                            <label class="form-check-label text-white" for="group_id">{{ strtoupper($group->group_title) }}</label>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="row pt-4" id="submit_button">
                        <div class="col-12 ">
                            <button class="btn upg-add-img-btn w-100">Update</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

<script type="text/javascript">
    function recipentByName(current) {
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        var base_path = '<?= $base_url ?>';

        if (obj != null) {
            len = obj.length;
        }

        var recipent_name = document.getElementById('name').value;
        var div_recipient = $('#show_recipents');
        var for_recipient_id = 'recipient_id[]';
        var for_all_recipient = 'all_recipient';

        if (recipent_name != '') {
            recipent_name = recipent_name.toLowerCase();
            div_recipient.empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var name = obj[i].name;
                    name = name.toLowerCase();
                    if (recipent_name == name) {
                        var recipient_id = obj[i].recipient_id;
                        var profile_image = obj[i].profile_image;

                        var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="' + recipient_id + '"> ' + name + '</p></div>';

                        div_recipient.append(recipent);
                    }
                }
            }
        } else {
            var all_recipient = '<div class="col-lg-2 col-3 rec-images"><img src="' + base_path + '/public/media/image/all-users.png"><p class="cl-white sel-text mt-3"><input class="form-check-input" type="checkbox" id="' + for_all_recipient + '" name="' + for_all_recipient + '" value="all" onclick="selectAllRecipient(this)"> All</p></div>';
            div_recipient.empty();
            div_recipient.append(all_recipient);

            for (var i = 0; i < len; i++) {
                var name = obj[i].name;
                name = name.toLowerCase();
                var recipient_id = obj[i].recipient_id;
                var profile_image = obj[i].profile_image;

                var recipent = '<div class="col-lg-2 col-3 rec-images"><img class="recipent-img" src="' + base_path + profile_image + '" /><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="' + recipient_id + '"> ' + name + '</p></div>';

                div_recipient.append(recipent);
            }
        }
    }

    function selectAllRecipient(current) {
        var inputs = document.querySelectorAll('.user-recipient');
        if (current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if (current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }

    function groupByName(current) {
        var obj = JSON.parse('<?php echo json_encode($groups) ?>');
        var base_path = '<?= $base_url ?>';

        if (obj != null) {
            len = obj.length;
        }

        var group_name = document.getElementById('group_name').value;
        var div_group = $('#show_groups');
        var for_group_id = 'group_id[]';
        var for_all_group = 'all_group';
        
        if (group_name != '') {
            group_name = group_name.toLowerCase();
            div_group.empty();
            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var group_title = obj[i].group_title;
                    group_title = group_title.toLowerCase();
                    if (group_name == group_title) {
                        var id = obj[i].id;
                        group_title = group_title.toUpperCase();
                        var group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="' + for_group_id + '" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                        div_group.append(group);
                    }
                }
            }
        } else {
            var all_group = '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="' + for_all_group + '" name="' + for_all_group + '" value="all" onclick="selectAllGroup(this)"><label class="form-check-label text-white" for="group_id">All</label></div>';
            div_group.empty();
            div_group.append(all_group);

            for (var i = 0; i < len; i++) {
                var group_title = obj[i].group_title;
                var id = obj[i].id;
                group_title = group_title.toUpperCase();
                var group = '<div class="form-check form-check-inline"><input class="form-check-input user-group" type="checkbox" name="' + for_group_id + '" value="' + id + '"><label class="form-check-label text-white" for="group_id">' + group_title + '</label></div>';

                div_group.append(group);
            }
        }
    }

    function selectAllGroup(current) {
        var inputs = document.querySelectorAll('.user-group');
        if (current.checked == true) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }
        }
        if (current.checked == false) {
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }
        }
    }

    function validateForm(current) {
        return true;
    }
</script>