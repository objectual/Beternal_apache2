@extends("frontend.layouts.layout")
@section("title","View Recipient")
@section("content")
<div class="container-fluid bg-create recipent-back pb-5 pt-5">
    <div class="scroll-div">
        <div class="col-lg-6 offset-lg-3">
            <div class="login recipent-back-clr">
                <div class="row">
                    <div class="col-lg-6 col-10 text-start">

                    </div>
                    <div class="col-lg-6 col-2 text-end">
                        <a href="#" class="icon-edit">
                            <img class="mt-2 img-edit" src="{{ asset('public/assets/images/edit.png') }}" /></a>
                    </div>
                </div>
                <img class="acc-img  pb-3" src="{{ asset('public/assets/images/recipent.png') }}" />
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Name</p>
                        <p class="recipent-data m-0">Nina Brethert</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Email</p>
                        <p class="recipent-data m-0">ninabrethert@gmail.com</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Phone</p>
                        <p class="recipent-data m-0">+123 123 123</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Status</p>
                        <p class="recipent-data m-0">First</p>
                        <hr />
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-12 margin-recipent">
                        <p class="recipent-data recipent-label m-0">Group</p>
                        <p class="recipent-data m-0 mb-4">Friends</p>
                    </div>
                </div>
                <a href="{{ route('user.recipents.add-form') }}" class="btn mb-3 text-center mt-1 col-md-7 col-sm-12 recipent-btn">
                    <span class="cl-back">Add More Recipent</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection