@extends("frontend.layouts.layout")
@section("title","My Media Details")
@section("content")
@php $base_url = url(''); @endphp
@if(isset($message))
<div class="container-fluid success-bg">
    <div class="row pt-3">
        <div class="col-lg-4 offset-lg-4 text-center success-img-bg">
            <div class="row">
                <div class="col-lg-8 text-center offset-lg-2">
                    <h5 class="mt-5 payment-h3 text-white">{{ $message }}</h5>
                    <img class="signup-success" src="{{ asset('/public/assets/images/success-signup.svg') }}" />
                    <div class="text-center mb-4">
                        <a href="{{ route('splash') }}" class="btn w-100 bg-black mb-3 m-auto text-center py-2 mt-3">
                            <span class="schedule text-white">CONTINUE</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid shared-back-light pt-5 pb-3  bg-calendar">
    <div class="col-lg-10 offset-lg-1 my-media-detail-padding">
        <div class="scroll-div row-height">
            <div class="row">
                <div class="col-lg-6 mt-3">
                    @if($schedule_media[0]->type == 'video')
                    @php
                        $format = explode(".", $schedule_media[0]->file_name);
                        $ios = '#t=0.001';
                        if ($format[1] == 'mov') {
                            $set_format = 'video/mp4';
                        } else {
                            $set_format = 'video/'.$format[1];
                        }
                    @endphp
                    <div class="">
                        <video id="ban_video" class="tv_video email-video" controls>
                            <source src="{{ asset( $file_path.$schedule_media[0]->file_name.$ios )}}" type="{{ $set_format }}" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @elseif($schedule_media[0]->type == 'photo')
                    <div class="image" id="current_photo">
                        <picture id="ban_image" class="tv_image">
                            <img src="{{ asset( $file_path.$schedule_media[0]->file_name )}}" type="image" height="500" width="720" />
                        </picture>
                    </div>
                    @elseif($schedule_media[0]->type == 'audio')
                    <div class="audio">
                        <audio id="ban_audio" class="tv_audio" controls>
                            <source src="{{ asset( $file_path.$schedule_media[0]->file_name )}}" type="audio/mp3" />
                            Your browser does not support the video tag.
                        </audio>
                    </div>
                    @endif
                </div>
                <div class="col-lg-6 mt-3">
                    <div class="row">
                        <div class="col-lg-12 text-start">
                            <label class="text-white">Description</label>
                            <div class="mb-3">
                                <textarea class="Description-form text-white" rows="3" readonly>{{ $schedule_media[0]->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-start">
                            <label class="text-white">Personal Message</label>
                            <div class="mb-3">
                                <textarea class="Description-form text-white" rows="3" readonly>{{ $schedule_media[0]->message }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
