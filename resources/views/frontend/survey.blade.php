@extends("frontend.layouts.layout")
@section("title","Survey")
@section("content")
<div class="container-fluid survey-back survey-padding h-100">
    <div class="scroll-div survey-mob-padding">
        <div class="row col-md-10 m-auto px-4 pb-5 pt-5 survey-mob-padding">
            <div class="col-lg-10 mt-3">
                <h3 class="sur-head cl-white">HOW ARE WE DOING?</h3>
                <p class="cl-white">We are very interested in your opinion. Let us know how we can improve or what you like. Thank you!</p>
            </div>
            <div class="col-lg-2 mt-3 text-end sur-like">
                <a href="#" class="icon-like like active-live"></a>
                <a href="#" class="icon-disLike dislike mx-2"></a>
            </div>
            <div class="col-lg-12 mt-3">
                <textarea class="w-100 border-0 sur-placeholder" placeholder="What do you like and how can we be better?" rows="10"></textarea>
                <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn m-auto text-center py-3 mt-3 survey-mob-btn survey-btn">
                    <span class="schedule">SUBMIT</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection