@extends("frontend.layouts.layout")
@section("title","My Media Details")
@section("content")
@php $base_url = url(''); @endphp
<div class="container-fluid shared-back-light pt-5 pb-3  bg-calendar">
    <div class="col-lg-10 offset-lg-1 my-media-detail-padding">
        <div class="scroll-div">
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <div class=" col-md-12 col-12 justify-content-end d-flex ">
                        <!-- <a href="">
                            <img src="{{ asset('/public/assets/images/edit-icon-media-details.png') }}" class="edit-icon-style mt-1">
                            <p class="px-2 text-white mx-1">Edit</p>
                        </a> -->
                        <a id="{{ $get_media[0]->id }}" class="d-flex" data-bs-target="#delete" onclick="deleteMedia(this)">
                            <img src="{{ asset('/public/assets/images/delete-new.png') }}" class="delete-icon-style mt-1">
                            <p class="px-2 text-white mx-1">Delete</p>
                        </a>
                    </div>
                    @if($get_media[0]->type == 'video')
                    <div class="video">
                        <video id="ban_video" class="tv_video" controls>
                            <source src="{{ asset( $file_path.$get_media[0]->file_name )}}" type="video/mp4" />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @elseif($get_media[0]->type == 'photo')
                    <div class="image" id="current_photo">
                        <picture id="ban_image" class="tv_image">
                            <img src="{{ asset( $file_path.$get_media[0]->file_name )}}" type="image" height="500" width="720" />
                        </picture>
                    </div>
                    @elseif($get_media[0]->type == 'audio')
                    <div class="audio">
                        <audio id="ban_audio" class="tv_audio" controls>
                            <source src="{{ asset( $file_path.$get_media[0]->file_name )}}" type="audio/mp3" />
                            Your browser does not support the video tag.
                        </audio>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-lg-4 text-start mt-4">
                    <p class="media-head text-white">{{ $get_media[0]->title }}</p>
                 <p class="media-head text-white">{{ $get_media[0]->description }}</p>
                 <p class="media-clock-p text-white"><img class="media-clock-img" src="{{ asset('/public/assets/images/clock.png') }}" />&nbsp;{{ $get_media[0]->created_at }}</p>


                </div>
                <div class="col-lg-4 text-white media-head mt-4">
                <div class=" d-flex">
                    <div class="text-white details-text">Groups : &nbsp;&nbsp;</div>
                    <div class="text-white p-0 details-text">
                    @if($get_media[0]->all_recipient != null)
                    @foreach($get_media[0]->all_group as $group)
                        {{ $group->group_title }},
                    @endforeach
                    @endif
                    </div>
                </div>
                </div>
                <div class="col-lg-4 text-end mt-4">
                @if($get_media[0]->all_recipient != null)
                    @foreach($get_media[0]->all_recipient as $recipient)
                    <div class="d-flex mb-4"> 
                    <div><img class="media-recipent" src="{{ asset($recipient->profile_image) }}"></div>
                    <div class="text-white details-text mx-2">{{ $recipient->name }} {{ $recipient->last_name }},</div>
                    </div>
                    
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- <div class="row mt-1">
                <div class="row d-flex">
                    <div class="col-md-1 col-6 text-white details-text">Groups :</div>
                    <div class="text-white col-md-11 p-0 col-5 details-text">
                        @if($get_media[0]->all_recipient != null)
                        @foreach($get_media[0]->all_group as $group)
                        {{ $group->group_title }},
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="row d-flex">
                    @if($get_media[0]->all_recipient != null)
                    @foreach($get_media[0]->all_recipient as $recipient)
                    <div class="d-flex col-md-3 mb-4"> 
                    <div><img class="media-recipent" src="{{ asset($recipient->profile_image) }}"></div>
                    <div class="text-white details-text mx-2">{{ $recipient->name }} {{ $recipient->last_name }},</div>
                    </div>
                    
                    @endforeach
                    @endif
                </div>
            </div> -->

          

            <!-- <div class="row mt-1">
                <div class="col-lg-12">
                    <p class="media-head text-white">{{ $get_media[0]->description }}</p>
                </div>
            </div> -->
        </div>
    </div>

</div>

<div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 text-center offset-lg-3">
                        <p>
                            Are you sure you want to delete media ?
                        </p>
                        <div class="text-center mb-4">
                            <a href="" class="mx-1" id="delete_media"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                            <a class="mx-1" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function deleteMedia(current) {
        var base_url = '<?= $base_url ?>';
        var set_path = base_url + '/medias/my-media-delete/'+ current.id;
        var element = document.getElementById('delete_media');
        element.href = set_path;
        $("#delete").modal("show");
    }
</script>