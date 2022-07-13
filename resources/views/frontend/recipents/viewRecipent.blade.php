@extends("frontend.layouts.layout")
@section("title","View Recipient")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid bg-create recipent-back pb-5 pt-5">
    <div class="scroll-div row-height">
        <div class="col-lg-6 offset-lg-3">
            <div class="login mt-0 mb-0 recipent-back-clr">
                <div class="row">
                    <div class="col-lg-6 col-10 text-start">

                    </div>
                    <div class="col-lg-6 col-2 text-end">
                        <a href="{{ route('user.recipents.edit-recipent', ['id' => $recipient->recipient_id]) }}" class="icon-edit">
                            <img class="mt-2 img-edit" src="{{ asset('public/assets/images/edit.png') }}" />
                        </a>
                        <a id="{{ $recipient->recipient_id }}" class="icon-edit" data-bs-target="#delete" onclick="deleteRecipient(this)">
                            <img class="mt-2 img-edit" src="{{ asset('/public/assets/images/delete-new.png') }}" />
                        </a>
                    </div>
                </div>
                <img class="acc-img" src="{{ asset($recipient->profile_image) }}" style="border-radius: 100%" />
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Name</p>
                        <p class="recipent-data m-0 text-white">{{ $recipient->name }} {{ $recipient->last_name }}</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Email</p>
                        <p class="recipent-data m-0 text-white">{{ $recipient->email }}</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent phone-area">
                        <p class="recipent-data recipent-label m-0">Phone</p>
                        <p class="recipent-data m-0 text-white">{{ $recipient->phone_number }}</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Status</p>
                        <p class="recipent-data m-0 text-white">{{ $recipient->contact_title }}</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Group</p>
                        <p class="recipent-data m-0 mb-4 text-white">{{ $recipient->group_title }}</p>
                    </div>
                </div>
                <a href="{{ route('user.recipents.add-form') }}" class="btn mb-3 text-center mt-1 col-md-7 col-sm-12 recipent-btn">
                    <span class="cl-back">ADD ANOTHER RECIPIENT</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade delete-recipent" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 text-center offset-lg-3">
                        <p class="text-white">
                            Are you sure you want to delete recipient ?
                        </p>
                        <div class="text-center mb-4">
                            <a href="" class="mx-1" id="delete_recipient"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                            <a class="mx-1 close-cancel" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function deleteRecipient(current) {
        var base_url = '<?= $base_url ?>';
        var set_path = base_url + '/recipents/delete-recipent/'+ current.id;
        var element = document.getElementById('delete_recipient');
        element.href = set_path;
        $("#delete").modal("show");
    }
</script>