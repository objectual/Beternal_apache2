@extends("frontend.layouts.layout")
@section("title","Delivery")
@section("content")
@php
$mydate = getdate(date("U"));
$day = "$mydate[weekday]";
$month = "$mydate[month]";
$date = "$mydate[mday]";
$year = "$mydate[year]";
$current_month = strtoupper($month);
$given_month = "$mydate[mon]";
$for_current_month = getdate(mktime(1, 1, 1, $given_month, 1, $year));
$first_day = "$for_current_month[weekday]";
@endphp
<div class="container-fluid bg-create delivery-padding bg-calendar">
    <div class="scroll-div">
        <div class="row">
            <div class="col-lg-12 mt-3 p-3 delivery-color">
                <div class="row px-5 p-0-m mt-5">

                    <input type="hidden" id="default_day" value="{{ $date }}">
                    <input type="hidden" id="default_month" value="{{ $given_month }}">
                    <input type="hidden" id="default_year" value="{{ $year }}">

                    <div class="col-lg-1 col-3 mb-4 text-start date-col">
                        <span class="date mt-3" id="current_date">{{ $date }}</span>
                    </div>
                    <div class="col-lg-7 col-9 remove" id="month_year">
                        <span class="month cl-white mt-3" id="current_month">{{ $month }}</span><br />
                        <span class="year cl-white mt-3" id="current_year">{{ $year }}</span>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div id="carouselExampleControls mob-col" class="carousel slide year-slide" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="cl-white" id="previous_month_next">
                                        {{ $current_month }}
                                    </p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" onclick="changeMonth('previous')">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" onclick="changeMonth('next')">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div id="carouselExampleControls mob-col" class="carousel slide year-slide" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="cl-white" id="previous_year_next">{{ $year }}</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" onclick="changeYear('previous')">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" onclick="changeYear('next')">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>

                @php
                $sunday_class = 'calendar-td-head weekdays-back';
                $monday_class = 'calendar-td-head weekdays-back';
                $tuesday_class = 'calendar-td-head weekdays-back';
                $wednesday_class = 'calendar-td-head weekdays-back';
                $thursday_class = 'calendar-td-head weekdays-back';
                $friday_class = 'calendar-td-head weekdays-back';
                $saturday_class = 'calendar-td-head weekdays-back';
                @endphp

                @if($day == 'Sunday')
                @php $sunday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Monday')
                @php $monday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Tuesday')
                @php $tuesday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Wednesday')
                @php $wednesday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Thursday')
                @php $thursday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Friday')
                @php $friday_class = 'calendar-td-head sunday'; @endphp
                @elseif($day == 'Saturday')
                @php $saturday_class = 'calendar-td-head sunday'; @endphp
                @endif

                @php
                $days_28 = 28;
                $days_29 = 29;
                $days_30 = 30;
                $days_31 = 31;
                $month_30 = array('April', 'June', 'September', 'November');
                $month_31 = array('January', 'March', 'May', 'July', 'August', 'October', 'December');
                $week_days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                @endphp

                <div class="row px-5 p-0-m">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="mb-1 w-100 delivery-calendar">
                                <thead>
                                    <tr id="days_name">
                                        <td class="{{ $sunday_class }}">Sun</td>
                                        <td class="{{ $monday_class }}">Mon</td>
                                        <td class="{{ $tuesday_class }}">Tue</td>
                                        <td class="{{ $wednesday_class }}">Wed</td>
                                        <td class="{{ $thursday_class }}">Thu</td>
                                        <td class="{{ $friday_class }}">Fri</td>
                                        <td class="{{ $saturday_class }}">Sat</td>
                                    </tr>
                                </thead>
                                <tbody id="show_date">
                                    @php $first_row = 0; @endphp
                                    @if(in_array($month, $month_31))
                                    <tr>
                                        @for($i = 0; $i < count($week_days); $i++) @php $first_row++; @endphp @if($week_days[$i]==$first_day) @if($date==1) <td>
                                            <p class="event-active">1</p>
                                            </td>
                                            @else
                                            <td>
                                                <p class="cl-white" style="background-image: url('{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}'); background-size: cover;">1</p>
                                            </td>
                                            @endif
                                            @if($first_row == 7)
                                    </tr>
                                    <tr>
                                        @endif
                                        @php break; @endphp
                                        @else
                                        <td></td>
                                        @endif
                                        @endfor
                                        @php
                                        $row_break = $first_row;
                                        $days_31 + $first_row;
                                        @endphp
                                        @for($i = 2; $i <= $days_31; $i++) @php $row_break++; @endphp @if($date==$i) <td>
                                            <p class="event-active">{{ $i }}</p>
                                            </td>
                                            @else
                                            <td>
                                                <p class="">{{ $i }}</p>
                                            </td>
                                            @endif
                                            @if($row_break == 7 || $row_break == 14 || $row_break == 21 ||
                                            $row_break == 28 || $row_break == 35)
                                    </tr>
                                    <tr>
                                        @endif
                                        @endfor
                                    </tr>
                                    @elseif(in_array($month, $month_30))
                                    <tr>
                                        @for($i = 0; $i < count($week_days); $i++) @php $first_row++; @endphp @if($week_days[$i]==$first_day) @if($date==1) <td onclick="selectMedia(1)">
                                            <p class="event-active">1</p>
                                            </td>
                                            @else
                                            <td onclick="selectMedia(1)">
                                                <p class="cl-white" style="background-image: url('{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}'); background-size: cover;">1</p>
                                            </td>
                                            @endif
                                            @if($first_row == 7)
                                    </tr>
                                    <tr>
                                        @endif
                                        @php break; @endphp
                                        @else
                                        <td></td>
                                        @endif
                                        @endfor
                                        @php
                                        $row_break = $first_row;
                                        $days_30 + $first_row;
                                        @endphp
                                        @for($i = 2; $i <= $days_30; $i++) @php $row_break++; @endphp @if($date==$i) <td onclick="selectMedia({{ $i }})">
                                            <p class="event-active">{{ $i }}</p>
                                            </td>
                                            @else
                                            <td onclick="selectMedia({{ $i }})">
                                                <p class="">{{ $i }}</p>
                                            </td>
                                            @endif
                                            @if($row_break == 7 || $row_break == 14 || $row_break == 21 ||
                                            $row_break == 28 || $row_break == 35)
                                    </tr>
                                    <tr>
                                        @endif
                                        @endfor
                                    </tr>
                                    @elseif($month = 'February')
                                    <tr>
                                        @for($i = 0; $i < count($week_days); $i++) @php $first_row++; @endphp @if($week_days[$i]==$first_day) @if($date==1) <td>
                                            <p class="event-active">1</p>
                                            </td>
                                            @else
                                            <td>
                                                <p class="cl-white" style="background-image: url('{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}'); background-size: cover;">1</p>
                                            </td>
                                            @endif
                                            @if($first_row == 7)
                                    </tr>
                                    <tr>
                                        @endif
                                        @php break; @endphp
                                        @else
                                        <td></td>
                                        @endif
                                        @endfor
                                        @php
                                        $row_break = $first_row;
                                        $days_30 + $first_row;
                                        @endphp
                                        @for($i = 2; $i <= $days_28; $i++) @php $row_break++; @endphp @if($date==$i) <td>
                                            <p class="event-active">{{ $i }}</p>
                                            </td>
                                            @else
                                            <td>
                                                <p class="">{{ $i }}</p>
                                            </td>
                                            @endif
                                            @if($row_break == 7 || $row_break == 14 || $row_break == 21 ||
                                            $row_break == 28 || $row_break == 35)
                                    </tr>
                                    <tr>
                                        @endif
                                        @endfor
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="row p-0-m">
                            <div class="col-lg-5">
                                <p class="text-white">Select Time Format</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label text-white" for="inlineRadio1">12 HOURS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label text-white" for="inlineRadio2">24 HOURS</label>
                                </div>
                            </div>
                            <div class="col-lg-7 mt-4 text-start">
                                <div class="time-bg">
                                    <span class="time mt-3">Time <span class="time-detail">Newfoundland
                                            (GMT-3:30)</span></span>
                                    <span class="time-digit mt-3">11:30 am</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 mt-4 delivery-form">
                            <div class="input-group py-3">
                                <input type="text" class="py-2  form-control search-input input-search-delivery" placeholder="Recipient name">
                                <div class="input-group-append">
                                    <a href="#"><img class="search-ico search-delivery" src="{{ asset('/public/assets/images/search-white.png') }}" /> </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 text-end p-0">
                                <div class="d-flex justify-content-end">
                                    <img src="{{ asset('/public/assets/images/recipent.png') }}" class="delivey-images mx-2">
                                    <img src="{{ asset('/public/assets/images/recipent.png') }}" class="delivey-images mx-2">
                                    <img src="{{ asset('/public/assets/images/recipent.png') }}" class="delivey-images mx-2">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mt-4 delivery-form">
                            <div class="mb-3">
                                <textarea class="Description-form" id="exampleFormControlTextarea1" rows="3" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 delivery-form">
                            <textarea class="Description-form" id="exampleFormControlTextarea1" rows="3" placeholder="Personal message"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 text-center add-legacy mt-4">
                                <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn w-100 delivery-schedule-btn m-auto text-center
                              py-3 mb-5">ADD EVENT</button>
                            </div>
                            <div class="col-lg-6 text-center mt-4">
                                <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn w-100 legacy-btn m-auto text-center py-3 mb-5">ADD TO MY LEGACY</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

</div>

<div class="modal fade" id="myMedia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" id="video_heading">My Video</h4>
                <div class="row" id="video_display">
                    <div class="col-lg-12 mt-3">
                        <div class="row mt-3 px-2" id="all_videos">
                            @if(isset($all_media))
                            @foreach($all_media as $key => $video)
                            @if($video->type == 'video')
                            @php $date_time = explode(" ", $video->created_at); @endphp
                            <div class="col-lg-3 px-1 col-6 col-md-4">
                                <a class="example-image-link d-block" id="{{ $video->file_name }}" onclick="selectVideo(this)">
                                    <img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                                    <div class="play-bt-exm-one"></div>
                                    <div class="pt-1 bg-black">
                                        <span class="above-img-span">
                                            {{ $video->title }}

                                        </span>

                                        <span class="group-color">
                                            Group : {{ $video->group_title }}
                                        </span>
                                    </div>
                                    <span class="ab-img-span">
                                        {{ $video->recipient_first_name }} {{ $video->recipient_last_name }}
                                    </span>

                                    <span class="date-time pb-2">
                                        {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                    </span>
                                </a>
                                <button class="btn-view-details" onclick="mediaSelect({{ $video->id }})">Select</button>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <h4 class="mt-5 text-center" id="photo_heading">My Photo</h4>
                <div class="row" id="photo_display">
                    <div class="col-lg-12 mt-3">
                        <div class="row mt-3 px-2" id="all_photos">
                            @if(isset($all_media))
                            @foreach($all_media as $key => $photo)
                            @if($photo->type == 'photo')
                            @php $date_time = explode(" ", $photo->created_at); @endphp
                            <div class="col-lg-3 px-1 col-6 col-md-4">
                                <a class="example-image-link" href="{{ asset( $file_path.$photo->file_name )}}" id="{{ $photo->file_name }}" data-lightbox="example-set" data-title="<span>{{ $photo->description }}</span><br /><span>{{ $photo->created_at }}</span>" onclick="">
                                    <img class="example-image" src="{{ asset( $file_path.$photo->file_name )}}" alt="" />

                                    <div class="bg-black p-1">
                                        <div class="d-flex pt-1 bg-black">
                                            <span class="above-img-span">
                                                {{ $photo->title }}

                                            </span>

                                            <span class="group-color">
                                                Group : {{ $photo->group_title }}
                                            </span>
                                        </div>
                                        <span class="ab-img-span">
                                            {{ $photo->recipient_first_name }} {{ $photo->recipient_last_name }}
                                        </span>

                                        <span class="date-time pb-2">
                                            {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                        </span>
                                    </div>
                                </a>
                                <button class="btn-view-details" onclick="mediaSelect({{ $photo->id }})">Select</button>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <h4 class="mt-5 text-center" id="audio_heading">My Audio</h4>
                <div class="row pb-5" id="audio_display">
                    <div class="col-lg-12 text-center mt-3">
                        <div class="row mt-3 px-2" id="all_audios">
                            @if(isset($all_media))
                            @foreach($all_media as $key => $audio)
                            @if($audio->type == 'audio')
                            @php $date_time = explode(" ", $audio->created_at); @endphp
                            <div class="col-lg-3 px-1 col-md-4 col-6">
                                <a class="example-image-link d-block" id="{{ $audio->file_name }}" onclick="selectAudio(this)">
                                    <img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt="" />
                                    <div class="audio-bt-exm-one"></div>

                                    <div class="bg-black p-1">
                                        <div class="pt-1 bg-black">
                                            <span class="above-img-span text-start">
                                                {{ $audio->title }}

                                            </span>

                                            <span class="group-color">
                                                Group : {{ $audio->group_title }}
                                            </span>
                                        </div>
                                        <span class="ab-img-span text-start">
                                            {{ $audio->recipient_first_name }} {{ $audio->recipient_last_name }}
                                        </span>

                                        <span class="date-time pb-2">
                                            {{ $date_time[0] }} &nbsp; {{ $date_time[1] }}
                                        </span>
                                    </div>

                                </a>
                                <button class="btn-view-details" onclick="mediaSelect({{ $audio->id }})">Select</button>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function changeMonth(current) {
        var default_day = document.getElementById('default_day');
        var default_month = document.getElementById('default_month');
        var default_year = document.getElementById('default_year');
        var current_date = '<?= $date ?>';
        var current_month = '<?= $given_month ?>';
        var current_year = '<?= $year ?>';
        var current_day = '<?= $day ?>';
        var normal_day = 'calendar-td-head weekdays-back';
        var active_day = 'calendar-td-head sunday';
        var class_sunday = normal_day;
        var class_monday = normal_day;
        var class_tuesday = normal_day;
        var class_wednesday = normal_day;
        var class_thursday = normal_day;
        var class_friday = normal_day;
        var class_saturday = normal_day;

        if (current == 'previous') {
            var get_day = 1;
            var get_month = default_month.value - 1;
            var get_year = default_year.value;

            if (get_month == 0) {
                get_month = 12;
                get_year = get_year - 1;
            }

            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var get_month_name = months[get_month - 1];
            var updated_month = get_month_name.toUpperCase();

            default_day.value = get_day;
            default_month.value = get_month;
            default_year.value = get_year;

            let new_date = new Date(get_year, get_month - 1, 1);
            var get_day = new_date.getDay();
        }
        if (current == 'next') {
            let new_date = new Date(default_year.value, default_month.value, 1);
            var get_year = new_date.getFullYear();
            var get_month_name = new_date.toLocaleString('default', {
                month: 'long'
            });
            var get_month = new_date.getMonth() + 1;
            var get_date = new_date.getDate();
            var get_day = new_date.getDay();
            var updated_month = get_month_name.toUpperCase();

            default_day.value = get_date;
            default_month.value = get_month;
            default_year.value = get_year;
        }

        $('#previous_month_next').empty();
        $('#previous_month_next').append(updated_month);
        $('#previous_year_next').empty();
        $('#previous_year_next').append(get_year);

        if (get_month == current_month && get_year == current_year) {
            if (current_day == 'Sunday') {
                class_sunday = active_day;
            } else if (current_day == 'Monday') {
                class_monday = active_day;
            } else if (current_day == 'Tuesday') {
                class_tuesday = active_day;
            } else if (current_day == 'Wednesday') {
                class_wednesday = active_day;
            } else if (current_day == 'Thursday') {
                class_thursday = active_day;
            } else if (current_day == 'Friday') {
                class_friday = active_day;
            } else if (current_day == 'Saturday') {
                class_saturday = active_day;
            }
        }

        var days_name = '<td class="' + class_sunday + '">Sun</td><td class="' + class_monday + '">Mon</td><td class="' + class_tuesday + '">Tue</td><td class="' + class_wednesday + '">Wed</td><td class="' + class_thursday + '">Thu</td><td class="' + class_friday + '">Fri</td><td class="' + class_saturday + '">Sat</td>';

        $('#days_name').empty();
        $('#days_name').append(days_name);

        var days_28 = 28;
        var days_30 = 30;
        var days_31 = 31;
        var month_30 = ['April', 'June', 'September', 'November'];
        var month_31 = ['January', 'March', 'May', 'July', 'August', 'October', 'December'];
        var week_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var first_day = week_days[get_day];
        var first_row = 0;

        if (get_year % 4 == 0) {
            days_28 = days_28 + 1;
        }

        if (month_31.includes(get_month_name)) {
            $('#show_date').empty();
            $('#show_date').append('<tr>');
            for (var i = 0; i < week_days.length; i++) {
                first_row++;
                if (week_days[i] == first_day) {
                    if (get_month == current_month && get_year == current_year) {
                        if (current_date == 1) {
                            $('#show_date').append('<td><p class="event-active">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        } else {
                            $('#show_date').append('<td><p class="">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        }
                    } else {
                        $('#show_date').append('<td><p class="">1</p></td>');
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                } else {
                    $('#show_date').append('<td></td>');
                }

            }
            var row_break = first_row;
            for (var i = 2; i <= days_31; i++) {
                row_break++;
                if (get_month == current_month && get_year == current_year) {
                    if (current_date == i) {
                        $('#show_date').append('<td><p class="event-active">' + i + '</p></td>');
                    } else {
                        $('#show_date').append('<td><p class="">' + i + '</p></td>');
                    }
                } else {
                    $('#show_date').append('<td><p class="">' + i + '</p></td>');
                }
                if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                    $('#show_date').append('</tr><tr>');
                }
            }
            $('#show_date').append('</tr>');
        } else if (month_30.includes(get_month_name)) {
            $('#show_date').empty();
            $('#show_date').append('<tr>');
            for (var i = 0; i < week_days.length; i++) {
                first_row++;
                if (week_days[i] == first_day) {
                    if (get_month == current_month && get_year == current_year) {
                        if (current_date == 1) {
                            $('#show_date').append('<td><p class="event-active">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        } else {
                            $('#show_date').append('<td><p class="">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        }
                    } else {
                        $('#show_date').append('<td><p class="">1</p></td>');
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                } else {
                    $('#show_date').append('<td></td>');
                }

            }
            var row_break = first_row;
            for (var i = 2; i <= days_30; i++) {
                row_break++;
                if (get_month == current_month && get_year == current_year) {
                    if (current_date == i) {
                        $('#show_date').append('<td><p class="event-active">' + i + '</p></td>');
                    } else {
                        $('#show_date').append('<td><p class="">' + i + '</p></td>');
                    }
                } else {
                    $('#show_date').append('<td><p class="">' + i + '</p></td>');
                }
                if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                    $('#show_date').append('</tr><tr>');
                }
            }
            $('#show_date').append('</tr>');
        } else if (get_month_name = 'February') {
            $('#show_date').empty();
            $('#show_date').append('<tr>');
            for (var i = 0; i < week_days.length; i++) {
                first_row++;
                if (week_days[i] == first_day) {
                    if (get_month == current_month && get_year == current_year) {
                        if (current_date == 1) {
                            $('#show_date').append('<td><p class="event-active">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        } else {
                            $('#show_date').append('<td><p class="">1</p></td>');
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        }
                    } else {
                        $('#show_date').append('<td><p class="">1</p></td>');
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                } else {
                    $('#show_date').append('<td></td>');
                }

            }
            var row_break = first_row;
            for (var i = 2; i <= days_28; i++) {
                row_break++;
                if (get_month == current_month && get_year == current_year) {
                    if (current_date == i) {
                        $('#show_date').append('<td><p class="event-active">' + i + '</p></td>');
                    } else {
                        $('#show_date').append('<td><p class="">' + i + '</p></td>');
                    }
                } else {
                    $('#show_date').append('<td><p class="">' + i + '</p></td>');
                }
                if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                    $('#show_date').append('</tr><tr>');
                }
            }
            $('#show_date').append('</tr>');
        }
    }

    function changeYear(current) {
        var default_day = document.getElementById('default_day');
        var default_month = document.getElementById('default_month');
        var default_year = document.getElementById('default_year');
        var set_day = 1;
        var set_month = 1;
        var set_year = default_year.value;
        var get_month_name = "January";
        var updated_month = get_month_name.toUpperCase();

        if (current == 'previous') {
            set_year--;
        } else if (current == 'next') {
            set_year++;
        }

        default_day.value = set_day;
        default_month.value = set_month;
        default_year.value = set_year;

        $('#previous_month_next').empty();
        $('#previous_month_next').append(updated_month);
        $('#previous_year_next').empty();
        $('#previous_year_next').append(set_year);

        var days_name = '<td class="calendar-td-head weekdays-back">Sun</td><td class="calendar-td-head weekdays-back">Mon</td><td class="calendar-td-head weekdays-back">Tue</td><td class="calendar-td-head weekdays-back">Wed</td><td class="calendar-td-head weekdays-back">Thu</td><td class="calendar-td-head weekdays-back">Fri</td><td class="calendar-td-head weekdays-back">Sat</td>';

        $('#days_name').empty();
        $('#days_name').append(days_name);

        let new_date = new Date(set_year, set_month - 1, 1);
        var get_day = new_date.getDay();
        var days_31 = 31;
        var week_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var first_day = week_days[get_day];
        var first_row = 0;


        $('#show_date').empty();
        $('#show_date').append('<tr>');
        for (var i = 0; i < week_days.length; i++) {
            first_row++;
            if (week_days[i] == first_day) {
                $('#show_date').append('<td><p class="">1</p></td>');
                if (first_row == 7) {
                    $('#show_date').append('</tr><tr>');
                }
                break;
            } else {
                $('#show_date').append('<td></td>');
            }
        }
        var row_break = first_row;
        for (var i = 2; i <= days_31; i++) {
            row_break++;
            $('#show_date').append('<td><p class="">' + i + '</p></td>');
            if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                $('#show_date').append('</tr><tr>');
            }
        }
        $('#show_date').append('</tr>');
    }

    function selectMedia(current) {
        $("#myMedia").modal("show");
    }

    function mediaSelect(current) {
        $("#myMedia").modal("hide");
    }
</script>