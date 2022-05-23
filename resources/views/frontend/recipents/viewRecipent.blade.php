@extends("frontend.layouts.layout")
@section("title","View Recipient")
@section("content")
<div class="container-fluid bg-create recipent-back pb-5 pt-5">
    <div class="scroll-div">
        <div class="col-lg-6 offset-lg-3">
            <div class="login mt-0 mb-0 recipent-back-clr">
                <div class="row">
                    <div class="col-lg-6 col-10 text-start">

                    </div>
                    <div class="col-lg-6 col-2 text-end">
                        <a href="{{ route('user.recipents.edit-recipent', ['id' => $recipient->recipient_id]) }}" class="icon-edit">
                            <img class="mt-2 img-edit" src="{{ asset('public/assets/images/edit.png') }}" />
                        </a>
                        <a href="{{ route('user.recipents.delete-recipent', ['id' => $recipient->recipient_id]) }}" class="icon-edit">
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
@endsection