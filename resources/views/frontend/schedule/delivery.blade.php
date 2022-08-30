@extends("frontend.layouts.layout")
@section("title","Delivery")
@section("content")
@php
    date_default_timezone_set(session()->get('user_timezone'));
    $mydate = getdate(date("U"));
    $minutes = "$mydate[minutes]";
    $hours = "$mydate[hours]";
    $day = "$mydate[weekday]";
    $month = "$mydate[month]";
    $date = "$mydate[mday]";
    $year = "$mydate[year]";
    $current_month = strtoupper($month);
    $given_month = "$mydate[mon]";
    $for_current_month = getdate(mktime(1, 1, 1, $given_month, 1, $year));
    $first_day = "$for_current_month[weekday]";
    $base_url = url('');
    $options_timezone = timezone_identifiers_list();
@endphp
@if(session()->has('message'))
@php $schedule_dates = ''; @endphp
<div class="modal-dialog logout-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10 text-center offset-lg-1">
                    <p class="text-white">{{ session()->get('message') }}</p>
                    <div class="text-center mb-4">
                        <a href="{{ route('user.delivery') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container-fluid bg-create delivery-padding bg-calendar">
    <div class="scroll-div row-height">
        <div class="row">
            <div class="col-lg-12 mt-3 p-3 delivery-color">
                <div class="row px-5 p-0-m mt-5">

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
                @php $schedule_dates = array(); @endphp
                @if(isset($schedule_media) && !$schedule_media->isEmpty())
                    @foreach($schedule_media as $media)
                        @php
                            $date_time = explode(' ', $media->date_time);
                            $month_year = explode('-', $date_time[0]);
                        @endphp
                        @if($month_year[0] == $year && $month_year[1] == $given_month)
                            @php
                                $your_schedule = array(
                                    'id' => $media->id,
                                    'file' => $media->file_name,
                                    'date' => $month_year[2],
                                    'type' => $media->type,
                                    'total_count' => count($media->multiple_media)
                                );
                                array_push($schedule_dates, $your_schedule);
                            @endphp
                        @endif
                    @endforeach
                @endif

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
                    $days_of_month = 0;
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
                                        @php $days_of_month = 31; @endphp
                                    @elseif(in_array($month, $month_30))
                                        @php $days_of_month = 30; @endphp
                                    @elseif($month = 'February')
                                        @php $days_of_month = 28; @endphp
                                    @endif
                                    <tr>
                                        @for($i = 0; $i < count($week_days); $i++)
                                            @php $first_row++; @endphp
                                            @if($week_days[$i] == $first_day)
                                                @if($date == 1)
                                                    @if(count($schedule_dates) > 0)
                                                        @php $set_media = 0; @endphp
                                                        @for($a = 0; $a < count($schedule_dates); $a++)
                                                            @if($schedule_dates[$a]['date'] == $date)
                                                                @php
                                                                    $id = $schedule_dates[$a]['id'];
                                                                    $file = $schedule_dates[$a]['file'];
                                                                    $type = $schedule_dates[$a]['type'];
                                                                    $total_count = $schedule_dates[$a]['total_count'];
                                                                @endphp
                                                                @if($type == 'video')
                                                                    @php
                                                                        $format = explode(".", $file);
                                                                        $ios = '#t=0.001';
                                                                        if ($format[1] == 'mov') {
                                                                            $set_format = 'video/mp4';
                                                                        } else {
                                                                            $set_format = 'video/'.$format[1];
                                                                        }
                                                                    @endphp
                                                                    <td id="1" onclick="mediaOption({{ $id }}, 1)">
                                                                        <p class="cl-white">&nbsp; &nbsp;1
                                                                            <video class="example-image video-calendar">
                                                                                <source src="{{ asset($file_path.$file.$ios) }}" type="{{ $set_format }}">
                                                                            </video>
                                                                            <a><img class="img-calendar-play" src="{{ asset('/public/assets/images/Exm-Buttons-Play.png') }}" /></a>
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @elseif($type == 'audio')
                                                                    @php $audio_file = '/public/assets/images/audio-pop.png'; @endphp
                                                                    <td id="1" onclick="mediaOption({{ $id }}, 1)">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($audio_file) }}'); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @else
                                                                    <td id="1" onclick="mediaOption({{ $id }}, 1)">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($file_path.$file) }}'); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @endif
                                                                @php
                                                                    $set_media++;
                                                                    $a = count($schedule_dates);
                                                                @endphp
                                                            @endif
                                                        @endfor
                                                        @if($set_media == 0)
                                                            <td id="1" onclick="selectMedia(1)">
                                                                <p class="event-active">&nbsp; &nbsp;1</p>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td id="1" onclick="selectMedia(1)">
                                                            <p class="event-active">&nbsp; &nbsp;1</p>
                                                        </td>
                                                    @endif
                                                @else
                                                    @if(count($schedule_dates) > 0)
                                                        @php $set_media = 0; @endphp
                                                        @for($b = 0; $b < count($schedule_dates); $b++)
                                                            @if($schedule_dates[$b]['date'] == 1)
                                                                @php
                                                                    $id = $schedule_dates[$b]['id'];
                                                                    $file = $schedule_dates[$b]['file'];
                                                                    $type = $schedule_dates[$b]['type'];
                                                                    $total_count = $schedule_dates[$b]['total_count'];
                                                                @endphp
                                                                @if($type == 'video')
                                                                    @php
                                                                        $format = explode(".", $file);
                                                                        $ios = '#t=0.001';
                                                                        if ($format[1] == 'mov') {
                                                                            $set_format = 'video/mp4';
                                                                        } else {
                                                                            $set_format = 'video/'.$format[1];
                                                                        }
                                                                    @endphp
                                                                    <td id="1" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white">&nbsp; &nbsp;1
                                                                            <video class="example-image video-calendar">
                                                                                <source src="{{ asset($file_path.$file.$ios) }}" type="{{ $set_format }}">
                                                                            </video>
                                                                            <a><img class="img-calendar-play" src="{{ asset('/public/assets/images/Exm-Buttons-Play.png') }}" /></a>
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @elseif($type == 'audio')
                                                                    @php $audio_file = '/public/assets/images/audio-pop.png'; @endphp
                                                                    <td id="1" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($audio_file) }}'); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @else
                                                                    <td id="1" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($file_path.$file) }}'); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @endif
                                                                @php
                                                                    $set_media++;
                                                                    $b = count($schedule_dates);
                                                                @endphp
                                                            @endif
                                                        @endfor
                                                        @if($set_media == 0)
                                                            <td id="1">
                                                                <p class="">&nbsp; &nbsp;1</p>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td id="1">
                                                            <p class="">&nbsp; &nbsp;1</p>
                                                        </td>
                                                    @endif
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
                                            $days_of_month + $first_row;
                                        @endphp
                                        @for($i = 2; $i <= $days_of_month; $i++)
                                            @php $row_break++; @endphp
                                            @if($date == $i)
                                                @if(count($schedule_dates) > 0)
                                                    @php $set_media = 0; @endphp
                                                    @for($j = 0; $j < count($schedule_dates); $j++)
                                                        @if($schedule_dates[$j]['date'] == $date)
                                                            @php
                                                                $id = $schedule_dates[$j]['id'];
                                                                $file = $schedule_dates[$j]['file'];
                                                                $type = $schedule_dates[$j]['type'];
                                                                $total_count = $schedule_dates[$j]['total_count'];
                                                            @endphp
                                                            @if($type == 'video')
                                                                @php
                                                                    $format = explode(".", $file);
                                                                    $ios = '#t=0.001';
                                                                    if ($format[1] == 'mov') {
                                                                        $set_format = 'video/mp4';
                                                                    } else {
                                                                        $set_format = 'video/'.$format[1];
                                                                    }
                                                                @endphp
                                                                <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                    <p class="cl-white">&nbsp; &nbsp;{{ $i }}
                                                                        <video class="example-image video-calendar">
                                                                            <source src="{{ asset($file_path.$file.$ios) }}" type="{{ $set_format }}">
                                                                        </video>
                                                                        <a><img class="img-calendar-play" src="{{ asset('/public/assets/images/Exm-Buttons-Play.png') }}" /></a>
                                                                        @if($total_count > 1)
                                                                        <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            @elseif($type == 'audio')
                                                                @php $audio_file = '/public/assets/images/audio-pop.png'; @endphp
                                                                <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                    <p class="cl-white" style="background-image: url('{{ asset($audio_file) }}'); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                        @if($total_count > 1)
                                                                        <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            @else
                                                                <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                    <p class="cl-white" style="background-image: url('{{ asset($file_path.$file) }}'); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                        @if($total_count > 1)
                                                                        <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            @endif
                                                            @php
                                                                $set_media++;
                                                                $j = count($schedule_dates);
                                                            @endphp
                                                        @endif
                                                    @endfor
                                                    @if($set_media == 0)
                                                        <td id="{{ $i }}" onclick="selectMedia({{ $i }})">
                                                            <p class="event-active">&nbsp; &nbsp;{{ $i }}</p>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td id="{{ $i }}" onclick="selectMedia({{ $i }})">
                                                        <p class="event-active">&nbsp; &nbsp;{{ $i }}</p>
                                                    </td>
                                                @endif
                                            @else
                                                @if($i > $date)
                                                    @if(count($schedule_dates) > 0)
                                                        @php $set_media = 0; @endphp
                                                        @for($k = 0; $k < count($schedule_dates); $k++)
                                                            @if($schedule_dates[$k]['date'] == $i)
                                                                @php
                                                                    $id = $schedule_dates[$k]['id'];
                                                                    $file = $schedule_dates[$k]['file'];
                                                                    $type = $schedule_dates[$k]['type'];
                                                                    $total_count = $schedule_dates[$k]['total_count'];
                                                                @endphp
                                                                @if($type == 'video')
                                                                    @php
                                                                        $format = explode(".", $file);
                                                                        $ios = '#t=0.001';
                                                                        if ($format[1] == 'mov') {
                                                                            $set_format = 'video/mp4';
                                                                        } else {
                                                                            $set_format = 'video/'.$format[1];
                                                                        }
                                                                    @endphp
                                                                    <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                        <p class="cl-white">&nbsp; &nbsp;{{ $i }}
                                                                            <video class="example-image video-calendar">
                                                                                <source src="{{ asset($file_path.$file.$ios) }}" type="{{ $set_format }}">
                                                                            </video>
                                                                            <a><img class="img-calendar-play" src="{{ asset('/public/assets/images/Exm-Buttons-Play.png') }}" /></a>
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @elseif($type == 'audio')
                                                                    @php $audio_file = '/public/assets/images/audio-pop.png'; @endphp
                                                                    <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($audio_file) }}'); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @else
                                                                    <td id="{{ $i }}" onclick="mediaOption({{ $id }}, {{ $i }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($file_path.$file) }}'); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @endif
                                                                @php
                                                                    $set_media++;
                                                                    $k = count($schedule_dates);
                                                                @endphp
                                                            @endif
                                                        @endfor
                                                        @if($set_media == 0)
                                                            <td id="{{ $i }}" onclick="selectMedia({{ $i }})">
                                                                <p class="">&nbsp; &nbsp;{{ $i }}</p>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td id="{{ $i }}" onclick="selectMedia({{ $i }})">
                                                            <p class="">&nbsp; &nbsp;{{ $i }}</p>
                                                        </td>
                                                    @endif
                                                @else
                                                    @if(count($schedule_dates) > 0)
                                                        @php $set_media = 0; @endphp
                                                        @for($n = 0; $n < count($schedule_dates); $n++)
                                                            @if($schedule_dates[$n]['date'] == $i)
                                                                @php
                                                                    $id = $schedule_dates[$n]['id'];
                                                                    $file = $schedule_dates[$n]['file'];
                                                                    $type = $schedule_dates[$n]['type'];
                                                                    $total_count = $schedule_dates[$n]['total_count'];
                                                                @endphp
                                                                @if($type == 'video')
                                                                    @php
                                                                        $format = explode(".", $file);
                                                                        $ios = '#t=0.001';
                                                                        if ($format[1] == 'mov') {
                                                                            $set_format = 'video/mp4';
                                                                        } else {
                                                                            $set_format = 'video/'.$format[1];
                                                                        }
                                                                    @endphp
                                                                    <td id="{{ $i }}" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white">&nbsp; &nbsp;{{ $i }}
                                                                            <video class="example-image video-calendar">
                                                                                <source src="{{ asset($file_path.$file.$ios) }}" type="{{ $set_format }}">
                                                                            </video>
                                                                            <a><img class="img-calendar-play" src="{{ asset('/public/assets/images/Exm-Buttons-Play.png') }}" /></a>
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @elseif($type == 'audio')
                                                                    @php $audio_file = '/public/assets/images/audio-pop.png'; @endphp
                                                                    <td id="{{ $i }}" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($audio_file) }}'); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @else
                                                                    <td id="{{ $i }}" onclick="actionMedia({{ $id }})">
                                                                        <p class="cl-white" style="background-image: url('{{ asset($file_path.$file) }}'); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;{{ $i }}
                                                                            @if($total_count > 1)
                                                                            <a><img class="multi" src="{{ asset('/public/assets/images/multi.png') }}" /></a>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                @endif
                                                                @php
                                                                    $set_media++;
                                                                    $n = count($schedule_dates);
                                                                @endphp
                                                            @endif
                                                        @endfor
                                                        @if($set_media == 0)
                                                            <td id="{{ $i }}" onclick="checkDate()">
                                                                <p class="">&nbsp; &nbsp;{{ $i }}</p>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td id="{{ $i }}" onclick="checkDate()">
                                                            <p class="">&nbsp; &nbsp;{{ $i }}</p>
                                                        </td>
                                                    @endif
                                                @endif
                                            @endif
                                            @if($row_break == 7 || $row_break == 14 || $row_break == 21 || $row_break == 28 || $row_break == 35)
                                                </tr>
                                                <tr>
                                            @endif
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <form method="POST" action="{{ route('user.schedule-delivery') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                        @csrf

                        <input type="hidden" id="default_day" name="default_day" value="{{ $date }}">
                        <input type="hidden" id="default_month" name="default_month" value="{{ $given_month }}">
                        <input type="hidden" id="default_year" name="default_year" value="{{ $year }}">
                        <input type="hidden" id="media_date" name="media_date" value="">
                        <input type="hidden" id="selected_file" name="selected_file" value="">
                        <input type="hidden" id="upload_type" name="upload_type" value="">
                        <input type="hidden" id="show_media" value="">
                        <input type="hidden" id="last_selected_media" value="">
                        <input type="hidden" id="timezone_minutes" value="">
                        <input type="hidden" id="timezone_hours" name="timezone_hours" value="">
                        <input type="hidden" id="timezone_date" value="">
                        <input type="hidden" id="timezone_month" value="">
                        <input type="hidden" id="timezone_year" value="">

                        <div class="col-lg-8 offset-lg-2">
                            <div class="row p-0-m">
                            <div class="col-lg-6"></div>
                                <div class="col-lg-5">
                                    <p class="text-white">Select Time Zone</p>
                                    <select id="pick_timezone" name="pick_timezone" class="form-select" aria-label="Default select example" onChange="selectTimezone()" oninvalid="this.setCustomValidity('Required Field')" oninput="setCustomValidity('')">
                                        <option selected value="">Time Zone</option>
                                        @for($i = 0; $i < count($options_timezone); $i++)
                                            <option value="{{ $options_timezone[$i] }}">
                                                {{ $options_timezone[$i] }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                            <div class="row p-0-m">
                                <div class="col-lg-5">
                                    <p class="text-white">Select Time Format</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="time_format" id="format_12" value="12" onchange="timeFormat(this)" checked>
                                        <label class="form-check-label text-white" for="time_format">12 HOURS</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="time_format" id="format_24" value="24" onchange="timeFormat(this)">
                                        <label class="form-check-label text-white" for="time_format">24 HOURS</label>
                                    </div>
                                </div>

                                <div class="col-lg-1"></div>
                                <div class="col-lg-6 d-flex timer-top ">
                                <select id="pick_hours" name="pick_hours" class="form-select filter-select sch-media-form hr" aria-label="Default select example" required>
                                        <option selected value="">Hours</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <select id="pick_minutes" name="pick_minutes" class="form-select filter-select sch-media-form min" aria-label="Default select example" required>
                                        <option selected value="">Minutes</option>
                                        @for($i = 0; $i < 60; $i++)
                                            @if($i < 10)
                                                @php $pick_minute = 0 . $i; @endphp
                                            @else
                                                @php $pick_minute = $i; @endphp
                                            @endif
                                            <option value="{{ $pick_minute }}">{{ $pick_minute }}</option>
                                        @endfor
                                    </select>
                                    <select id="day_night" name="day_night" class="form-select filter-select sch-media-form am" aria-label="Default select example">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div> 
                                <div class="col-6"></div>
                                <div class="col-6" id="show_time_msg"></div>
                            </div>
                            <div class="col-md-12 mt-4 delivery-form">
                                <div class="input-group py-3">
                                    <input type="text" id="name" class="py-2 form-control search-input input-search-delivery" placeholder="Search by Recipient's Name">
                                    <div class="input-group-append">
                                        <img class="search-ico search-delivery" src="{{ asset('/public/assets/images/search-white.png') }}" onclick="recipentByName()" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12 text-end p-0">
                                    <div class="d-flex justify-content-end flex-wrap" id="show_recipient">
                                        @if(isset($user_recipents) && !$user_recipents->isEmpty())
                                        <div class="rec-images text-center px-2">
                                            <img src="{{ asset('public/media/image/all-users.png') }}">
                                            <p class="cl-white sel-text mt-3">
                                                <input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all recipient" onclick="selectAllRecipient(this)">
                                                All
                                            </p>
                                        </div>
                                        @foreach($user_recipents as $key => $recipent)
                                        <div class="rec-images text-center px-2">
                                            <img src="{{ asset($recipent->profile_image) }}" class="delivey-images mx-2">
                                            <p class="cl-white sel-text mt-3">
                                                <input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="{{ $recipent->recipient_id }}">
                                                {{ $recipent->name }}
                                            </p>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12" id="show_recipient_msg" style="text-align: right;"></div>
                            </div>
                            <div class="col-md-12 mt-4 delivery-form">
                                <label class="text-white">Description</label>
                                <div class="mb-3">
                                    <textarea class="Description-form text-white" id="description" name="description" rows="3" placeholder="Type Here Description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 delivery-form">
                                <label class="text-white">Personal Message</label>
                                <textarea class="Description-form text-white" id="message" name="message" rows="3" placeholder="Type Here Personal Message"></textarea>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-lg-6 text-center add-legacy mt-4">
                                    <button data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn w-100 delivery-schedule-btn m-auto text-center py-3 mb-5" id="first_form">ADD EVENT</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2" id="show_media_msg"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 text-center add-legacy mt-4">
                                    <a class="btn w-100 delivery-schedule-btn m-auto text-center py-3 mb-5" onclick="uploadType('add_event')">ADD EVENT</a>
                                </div>
                                <div class="col-lg-6 text-center mt-4">
                                    <a class="btn w-100 legacy-btn m-auto text-center py-3 mb-5" onclick="uploadType('add_legacy')">ADD TO MY LEGACY</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>

</div>

<div class="modal fade" id="myMedia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-transparency">
            <div class="modal-body bg-black">
                <button type="button" class="close close-select-media" data-dismiss="myMedia" onclick="closeMedia()">&times;</button>
                <h4 class="text-center text-white mt-5" id="video_heading">My Video</h4>
                <div class="row" id="video_display">
                    <div class="col-lg-12 mt-3">
                        <div class="row mt-3 px-2" id="all_videos">
                            @if(isset($all_media))
                                @foreach($all_media as $key => $video)
                                    @if($video->type == 'video')
                                        @php
                                            $date_time = explode(" ", $video->created_at);
                                            $ios = '#t=0.001';
                                            if (isset($file)) {
                                                $format = explode(".", $file);
                                                if ($format[1] == 'mov') {
                                                    $set_format = 'video/mp4';
                                                } else {
                                                    $set_format = 'video/'.$format[1];
                                                }
                                            } else {
                                                $set_format = 'video/mp4';
                                            }
                                        @endphp
                                        <div class="col-lg-3 px-1 col-6 col-md-4">
                                            <a class="example-image-link d-block">
                                                <video class="example-image">
                                                    <source src="{{ asset( $file_path.$video->file_name.$ios )}}"type="{{ $set_format }}">
                                                </video>
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

                <h4 class="mt-5 text-center text-white" id="photo_heading">My Photo</h4>
                <div class="row" id="photo_display">
                    <div class="col-lg-12 mt-3">
                        <div class="row mt-3 px-2" id="all_photos">
                            @if(isset($all_media))
                            @foreach($all_media as $key => $photo)
                            @if($photo->type == 'photo')
                            @php $date_time = explode(" ", $photo->created_at); @endphp
                            <div class="col-lg-3 px-1 col-6 col-md-4">
                                <a class="example-image-link">
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

                <h4 class="mt-5 text-center text-white" id="audio_heading">My Audio</h4>
                <div class="row pb-5" id="audio_display">
                    <div class="col-lg-12 text-center mt-3">
                        <div class="row mt-3 px-2" id="all_audios">
                            @if(isset($all_media))
                            @foreach($all_media as $key => $audio)
                            @if($audio->type == 'audio')
                            @php $date_time = explode(" ", $audio->created_at); @endphp
                            <div class="col-lg-3 px-1 col-md-4 col-6">
                                <a class="example-image-link d-block">
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

<div class="modal fade" id="showMsg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog future-date-modal logout-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-10 text-center offset-lg-1">
                        <p class="text-white">Please select future date!</p>
                        <div class="text-center mb-4">
                            <a href="{{ route('user.delivery') }}" class="mx-1"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myScheduleMedia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-black">
            <div class="modal-body">
                <input type="hidden" id="delete_media" value="">
                <input type="hidden" id="date_media" value="">
                <input type="hidden" id="media_index" value="">
                <button type="button" class="close close-select-media" data-dismiss="myScheduleMedia" onclick="closeScheduleMedia()">&times;</button>

                <a class="icon-edit" data-bs-target="#delete" onclick="deleteMedia()"><img class="mt-2 img-edit" src="{{ asset('/public/assets/images/delete-new.png') }}" /></a>

                <style>
                    .mySlides {display:none}
                    .w3-left, .w3-right, .w3-badge {cursor:pointer}
                    .w3-badge {height:13px;width:13px;padding:0}
                    .w3-text-white, .w3-hover-text-white:hover {
                        color: #fff!important;
                    }
                    .w3-section, .w3-code {
                        margin-top: 16px!important;
                        margin-bottom: 16px!important;
                    }
                    .w3-center {
                        text-align: center!important;
                    }
                    .w3-large {
                        font-size: 38px!important;
                    }
                    .w3-container, .w3-panel {
                        padding: 0.01em 16px;
                    }

                    .w3-content, .w3-auto {
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .w3-tooltip, .w3-display-container {
                        position: relative;
                    }
                    .w3-display-bottommiddle {
                        position: absolute;
                        left: 50%;
                        bottom: 0;
                        transform: translate(-50%,0%);
                        -ms-transform: translate(-50%,0%);
                    }
                    .w3-container:after, .w3-container:before, .w3-panel:after, .w3-panel:before, .w3-row:after, .w3-row:before, .w3-row-padding:after, .w3-row-padding:before, .w3-cell-row:before, .w3-cell-row:after, .w3-clear:after, .w3-clear:before, .w3-bar:before, .w3-bar:after {
                        content: "";
                        display: table;
                        clear: both;
                    }
                    .w3-transparent, .w3-hover-none:hover {
                        background-color: transparent!important;
                    }
                    .w3-border {
                        border: 1px solid #ccc!important;
                    }
                    .w3-badge {
                        border-radius: 50%;
                    }

                    .w3-badge, .w3-tag {
                        background-color: #000;
                        color: #fff;
                        display: inline-block;
                        padding-left: 5px;
                        padding-right: 5px;
                        text-align: center;
                    }

                    .w3-white, .w3-hover-white:hover {
                    color: #000!important;
                    background-color: #fff!important;
                    }

                    .w3-left {
                        float: left!important;
                    }
                    .w3-right {
                        float: right!important;
                    }
                    .bull {
                        margin: 0px 5px;
                    }
                    .bull-active {
                        background: #fff !important;
                    } 
                </style>

                <div class="col-lg-8 offset-lg-2">
                    <div class="row p-0-m">
                        <div class="col-lg-3 text-center"></div>
                        <div class="col-lg-6"></div>
                        <div class="col-lg-3 text-center"></div>
                    </div>
                    <div class="row p-0-m">
                        <div class="col-lg-12">
                            <div class="slider-arr">
                                <span class="carousel-control-prev-icon" aria-hidden="true" onclick="changeMedia('previous')"></span>
                                <span class="carousel-control-next-icon" aria-hidden="true" onclick="changeMedia('next')"></span> 
                            </div>

                            <div class="w3-center" id="show_schedule_media">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row p-0-m">
                        <div class="col-lg-12 mt-4 text-start">
                            <div class="time-bg">
                                <span class="time mt-3" id="media_date_time"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-end p-0">
                            <div class="d-flex justify-content-end flex-wrap" id="schedule_recipient"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4 delivery-form">
                        <label class="text-white">Description</label>
                        <div class="mb-3">
                            <textarea class="Description-form text-white" id="media_description" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 delivery-form">
                        <label class="text-white">Personal Message</label>
                        <textarea class="Description-form text-white" id="media_personal_message" rows="3" readonly></textarea>
                    </div>            
                </div>
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
                            Are you sure you want to delete schedule media ?
                        </p>
                        <div class="text-center mb-4">
                            <a href="" class="mx-1" id="delete_schedule"><img src="{{ asset('/public/assets/images/yes.png') }}" /></a>
                            <a class="mx-1 close-cancel" data-bs-dismiss="modal" aria-label="Close"><img src="{{ asset('/public/assets/images/no.png') }}" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="scheduleOption" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-black">
            <div class="modal-body">
                <button type="button" class="close close-select-media" data-dismiss="myScheduleMedia" onclick="closeScheduleOption()">&times;</button>

                <input type="hidden" id="temp_media_id" value="">
                <input type="hidden" id="temp_date" value="">
                <div class="row pt-3 pb-4 mt-5 media-icons">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2 mb-2" onclick="yourSchedule('add_new')">Add New</button>
                    </div>
                    <div class="col-lg-3">
                        <button class="filter-btn btn w-100 text-center py-2 mb-2" onclick="yourSchedule('view_details')">View Details</button>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
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
        var base_path = '<?= $file_path ?>';
        var base_url = '<?= $base_url ?>';
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

        var days_of_month = 0;
        var month_30 = ['April', 'June', 'September', 'November'];
        var month_31 = ['January', 'March', 'May', 'July', 'August', 'October', 'December'];
        var week_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var first_day = week_days[get_day];
        var first_row = 0;
        var schedule_dates = JSON.parse('<?php echo json_encode($schedule_dates) ?>');

        if (month_31.includes(get_month_name)) {
            days_of_month = 31;
        } else if (month_30.includes(get_month_name)) {
            days_of_month = 30;
        } else if (get_month_name = 'February') {
            days_of_month = 28;
            if (get_year % 4 == 0) {
                days_of_month = days_of_month + 1;
            }
        }

        const future_dates = [];
        var schedule_media = JSON.parse('<?php echo json_encode($schedule_media) ?>');
        if (get_year > current_year) {
            if (schedule_media.length > 0) {
                for (var x = 0; x < schedule_media.length; x++) {
                    var get_date_time = schedule_media[x].date_time;
                    var date_time = get_date_time.split(" ");
                    var month_year = date_time[0].split("-");
                    var media_year = parseInt(month_year[0]);
                    var media_month = parseInt(month_year[1]);
                    var media_date = parseInt(month_year[2]);
                    if (media_year == get_year && media_month == get_month) {
                        const your_schedule = [{
                            'id': schedule_media[x].id,
                            'file': schedule_media[x].file_name,
                            'date': media_date,
                            'type': schedule_media[x].type,
                            'total_count': schedule_media[x].multiple_media.length
                        }];
                        future_dates.push(your_schedule);
                    }
                }
            }
        }
        if (get_year == current_year) {
            if (get_month < current_month) {
                if (schedule_media.length > 0) {
                    for (var x = 0; x < schedule_media.length; x++) {
                        var get_date_time = schedule_media[x].date_time;
                        var date_time = get_date_time.split(" ");
                        var month_year = date_time[0].split("-");
                        var media_year = parseInt(month_year[0]);
                        var media_month = parseInt(month_year[1]);
                        var media_date = parseInt(month_year[2]);
                        if (media_year == get_year && media_month == get_month) {
                            const your_schedule = [{
                                'id': schedule_media[x].id,
                                'file': schedule_media[x].file_name,
                                'date': media_date,
                                'type': schedule_media[x].type,
                                'total_count': schedule_media[x].multiple_media.length
                            }];
                            future_dates.push(your_schedule);
                        }
                    }
                }
            }
            if (get_month > current_month) {
                if (schedule_media.length > 0) {
                    for (var x = 0; x < schedule_media.length; x++) {
                        var get_date_time = schedule_media[x].date_time;
                        var date_time = get_date_time.split(" ");
                        var month_year = date_time[0].split("-");
                        var media_year = parseInt(month_year[0]);
                        var media_month = parseInt(month_year[1]);
                        var media_date = parseInt(month_year[2]);
                        if (media_year == get_year && media_month == get_month) {
                            const your_schedule = [{
                                'id': schedule_media[x].id,
                                'file': schedule_media[x].file_name,
                                'date': media_date,
                                'type': schedule_media[x].type,
                                'total_count': schedule_media[x].multiple_media.length
                            }];
                            future_dates.push(your_schedule);
                        }
                    }
                }
            }
        }
        if (get_year < current_year) {
            if (schedule_media.length > 0) {
                for (var x = 0; x < schedule_media.length; x++) {
                    var get_date_time = schedule_media[x].date_time;
                    var date_time = get_date_time.split(" ");
                    var month_year = date_time[0].split("-");
                    var media_year = parseInt(month_year[0]);
                    var media_month = parseInt(month_year[1]);
                    var media_date = parseInt(month_year[2]);
                    if (media_year == get_year && media_month == get_month) {
                        const your_schedule = [{
                            'id': schedule_media[x].id,
                            'file': schedule_media[x].file_name,
                            'date': media_date,
                            'type': schedule_media[x].type,
                            'total_count': schedule_media[x].multiple_media.length
                        }];
                        future_dates.push(your_schedule);
                    }
                }
            }
        }

        $('#show_date').empty();
        $('#show_date').append('<tr>');
        for (var i = 0; i < week_days.length; i++) {
            first_row++;
            if (week_days[i] == first_day) {
                if (get_month == current_month && get_year == current_year) {
                    if (current_date == 1) {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var a = 0; a < schedule_dates.length; a++) {
                                var schedule_date = parseInt(schedule_dates[a]['date']);
                                if (schedule_date == current_date) {
                                    var id = schedule_dates[a]['id'];
                                    var file = schedule_dates[a]['file'];
                                    var type = schedule_dates[a]['type'];
                                    var total_count = schedule_dates[a]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1<a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    a = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1" onclick="selectMedia(1)"><p class="event-active">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1" onclick="selectMedia(1)"><p class="event-active">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                    } else {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var b = 0; b < schedule_dates.length; b++) {
                                var schedule_date = parseInt(schedule_dates[b]['date']);
                                if (schedule_date == 1) {
                                    var id = schedule_dates[b]['id'];
                                    var file = schedule_dates[b]['file'];
                                    var type = schedule_dates[b]['type'];
                                    var total_count = schedule_dates[b]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    b = schedule_dates.length;
                                }
                            }
                            if(set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1"><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1"><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                    }
                    if (first_row == 7) {
                        $('#show_date').append('</tr><tr>');
                    }
                    break;
                } else {
                    if (get_year > current_year) {
                        if (future_dates.length > 0) {
                            var set_media = 0;
                            for (var y = 0; y < future_dates.length; y++) {
                                var schedule_date = parseInt(future_dates[y][0].date);
                                if (schedule_date == 1) {
                                    var id = future_dates[y][0].id;
                                    var file = future_dates[y][0].file;
                                    var type = future_dates[y][0].type;
                                    var total_count = future_dates[y][0].total_count;
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    y = future_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    } else if (get_year == current_year) {
                        if (get_month < current_month) {
                            if (future_dates.length > 0) {
                                var set_media = 0;
                                for (var y = 0; y < future_dates.length; y++) {
                                    var schedule_date = parseInt(future_dates[y][0].date);
                                    if (schedule_date == 1) {
                                        var id = future_dates[y][0].id;
                                        var file = future_dates[y][0].file;
                                        var type = future_dates[y][0].type;
                                        var total_count = future_dates[y][0].total_count;
                                        var for_multi = '/public/assets/images/multi.png';
                                        var multi_file_icon = '';
                                        if (total_count > 1) {
                                            multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                        }
                                        if (type == 'video') {
                                            var my_file = file.split(".");
                                            var set_format = '';
                                            var ios = '#t=0.001';
                                            if (my_file[1] == 'mov') {
                                                set_format = 'video/mp4';
                                            } else {
                                                set_format = 'video/' + my_file[1];
                                            }
                                            var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                            $('#show_date').append(
                                                '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios+'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                            );
                                        } else if (type == 'audio') {
                                            var file_url = '/public/assets/images/audio-pop.png';
                                            $('#show_date').append(
                                                '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                            );
                                        } else {
                                            $('#show_date').append(
                                                '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                            );
                                        }
                                        set_media++;
                                        y = future_dates.length;
                                    }
                                }
                                if (set_media == 0) {
                                    $('#show_date').append(
                                        '<td><p class="">&nbsp; &nbsp;1</p></td>'
                                    );
                                }
                            } else {
                                $('#show_date').append(
                                    '<td><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        }
                        if (get_month > current_month) {
                            if (future_dates.length > 0) {
                                var set_media = 0;
                                for (var y = 0; y < future_dates.length; y++) {
                                    var schedule_date = parseInt(future_dates[y][0].date);
                                    if (schedule_date == 1) {
                                        var id = future_dates[y][0].id;
                                        var file = future_dates[y][0].file;
                                        var type = future_dates[y][0].type;
                                        var total_count = future_dates[y][0].total_count;
                                        var for_multi = '/public/assets/images/multi.png';
                                        var multi_file_icon = '';
                                        if (total_count > 1) {
                                            multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                        }
                                        if (type == 'video') {
                                            var my_file = file.split(".");
                                            var set_format = '';
                                            var ios = '#t=0.001';
                                            if (my_file[1] == 'mov') {
                                                set_format = 'video/mp4';
                                            } else {
                                                set_format = 'video/' + my_file[1];
                                            }
                                            var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                            $('#show_date').append(
                                                '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                            );
                                        } else if (type == 'audio') {
                                            var file_url = '/public/assets/images/audio-pop.png';
                                            $('#show_date').append(
                                                '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                            );
                                        } else {
                                            $('#show_date').append(
                                                '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                            );
                                        }
                                        set_media++;
                                        y = future_dates.length;
                                    }
                                }
                                if (set_media == 0) {
                                    $('#show_date').append(
                                        '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                                    );
                                }
                            } else {
                                $('#show_date').append(
                                    '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                            if (first_row == 7) {
                                $('#show_date').append('</tr><tr>');
                            }
                            break;
                        }
                    } else if (get_year < current_year) {
                        if (future_dates.length > 0) {
                            var set_media = 0;
                            for (var y = 0; y < future_dates.length; y++) {
                                var schedule_date = parseInt(future_dates[y][0].date);
                                if (schedule_date == 1) {
                                    var id = future_dates[y][0].id;
                                    var file = future_dates[y][0].file;
                                    var type = future_dates[y][0].type;
                                    var total_count = future_dates[y][0].total_count;
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    y = future_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                }
            } else {
                $('#show_date').append('<td></td>');
            }
        }
        var row_break = first_row;
        for (var i = 2; i <= days_of_month; i++) {
            row_break++;
            if (get_month == current_month && get_year == current_year) {
                if (current_date == i) {
                    if (schedule_dates.length > 0) {
                        var set_media = 0;
                        for (var j = 0; j < schedule_dates.length; j++) {
                            var schedule_date = parseInt(schedule_dates[j]['date']);
                            if (schedule_date == current_date) {
                                var id = schedule_dates[j]['id'];
                                var file = schedule_dates[j]['file'];
                                var type = schedule_dates[j]['type'];
                                var total_count = schedule_dates[j]['total_count'];
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                j = schedule_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="event-active">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="event-active">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                } else {
                    if (i > current_date) {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var k = 0; k < schedule_dates.length; k++) {
                                var schedule_date = parseInt(schedule_dates[k]['date']);
                                if (schedule_date == i) {
                                    var id = schedule_dates[k]['id'];
                                    var file = schedule_dates[k]['file'];
                                    var type = schedule_dates[k]['type'];
                                    var total_count = schedule_dates[k]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    k = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var n = 0; n < schedule_dates.length; n++) {
                                var schedule_date = parseInt(schedule_dates[n]['date']);
                                if (schedule_date == i) {
                                    var id = schedule_dates[n]['id'];
                                    var file = schedule_dates[n]['file'];
                                    var type = schedule_dates[n]['type'];
                                    var total_count = schedule_dates[n]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    n = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="'+ i +'" onclick="checkDate()"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="'+ i +'" onclick="checkDate()"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    }
                }
            } else {
                if (get_year == current_year && get_month > current_month) {
                    if (future_dates.length > 0) {
                        var set_media = 0;
                        for (var y = 0; y < future_dates.length; y++) {
                            if (future_dates[y][0].date == i) {
                                var id = future_dates[y][0].id;
                                var file = future_dates[y][0].file;
                                var type = future_dates[y][0].type;
                                var total_count = future_dates[y][0].total_count;
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                y = future_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                } else if (get_year > current_year) {
                    if (future_dates.length > 0) {
                        var set_media = 0;
                        for (var y = 0; y < future_dates.length; y++) {
                            if (future_dates[y][0].date == i) {
                                var id = future_dates[y][0].id;
                                var file = future_dates[y][0].file;
                                var type = future_dates[y][0].type;
                                var total_count = future_dates[y][0].total_count;
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                y = future_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                } else {
                    if (future_dates.length > 0) {
                        var set_media = 0;
                        for (var y = 0; y < future_dates.length; y++) {
                            if (future_dates[y][0].date == i) {
                                var id = future_dates[y][0].id;
                                var file = future_dates[y][0].file;
                                var type = future_dates[y][0].type;
                                var total_count = future_dates[y][0].total_count;
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                y = future_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                }
            }
            if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                $('#show_date').append('</tr><tr>');
            }
        }
        $('#show_date').append('</tr>');
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
        var current_date = '<?= $date ?>';
        var current_month = '<?= $given_month ?>';
        var current_year = '<?= $year ?>';
        var current_day = '<?= $day ?>';
        var base_path = '<?= $file_path ?>';
        var base_url = '<?= $base_url ?>';
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

        if (set_month == current_month && set_year == current_year) {
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

        let new_date = new Date(set_year, set_month - 1, 1);
        var get_day = new_date.getDay();
        var days_31 = 31;
        var week_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var first_day = week_days[get_day];
        var first_row = 0;
        var schedule_dates = JSON.parse('<?php echo json_encode($schedule_dates) ?>');
        var schedule_media = JSON.parse('<?php echo json_encode($schedule_media) ?>');
        const future_dates = [];

        if (set_year > current_year) {
            if (schedule_media.length > 0) {
                for (var x = 0; x < schedule_media.length; x++) {
                    var get_date_time = schedule_media[x].date_time;
                    var date_time = get_date_time.split(" ");
                    var month_year = date_time[0].split("-");
                    var media_year = parseInt(month_year[0]);
                    var media_month = parseInt(month_year[1]);
                    var media_date = parseInt(month_year[2]);
                    if (media_year == set_year && media_month == set_month) {
                        const your_schedule = [{
                            'id': schedule_media[x].id,
                            'file': schedule_media[x].file_name,
                            'date': media_date,
                            'type': schedule_media[x].type
                        }];
                        future_dates.push(your_schedule);
                    }
                }
            }
        }
        if (set_year == current_year) {
            if (schedule_media.length > 0) {
                for (var x = 0; x < schedule_media.length; x++) {
                    var get_date_time = schedule_media[x].date_time;
                    var date_time = get_date_time.split(" ");
                    var month_year = date_time[0].split("-");
                    var media_year = parseInt(month_year[0]);
                    var media_month = parseInt(month_year[1]);
                    var media_date = parseInt(month_year[2]);
                    if (media_year == set_year && media_month == set_month) {
                        const your_schedule = [{
                            'id': schedule_media[x].id,
                            'file': schedule_media[x].file_name,
                            'date': media_date,
                            'type': schedule_media[x].type
                        }];
                        future_dates.push(your_schedule);
                    }
                }
            }
        }
        if (set_year < current_year) {
            if (schedule_media.length > 0) {
                for (var x = 0; x < schedule_media.length; x++) {
                    var get_date_time = schedule_media[x].date_time;
                    var date_time = get_date_time.split(" ");
                    var month_year = date_time[0].split("-");
                    var media_year = parseInt(month_year[0]);
                    var media_month = parseInt(month_year[1]);
                    var media_date = parseInt(month_year[2]);
                    if (media_year == set_year && media_month == set_month) {
                        const your_schedule = [{
                            'id': schedule_media[x].id,
                            'file': schedule_media[x].file_name,
                            'date': media_date,
                            'type': schedule_media[x].type
                        }];
                        future_dates.push(your_schedule);
                    }
                }
            }
        }

        $('#show_date').empty();
        $('#show_date').append('<tr>');
        for (var i = 0; i < week_days.length; i++) {
            first_row++;
            if (week_days[i] == first_day) {
                if (set_month == current_month && set_year == current_year) {
                    if (current_date == 1) {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var a = 0; a < schedule_dates.length; a++) {
                                var schedule_date = parseInt(schedule_dates[a]['date']);
                                if (schedule_date == current_date) {
                                    var id = schedule_dates[a]['id'];
                                    var file = schedule_dates[a]['file'];
                                    var type = schedule_dates[a]['type'];
                                    var total_count = schedule_dates[a]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    a = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1" onclick="selectMedia(1)"><p class="event-active">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1" onclick="selectMedia(1)"><p class="event-active">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                    } else {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var b = 0; b < schedule_dates.length; b++) {
                                var schedule_date = parseInt(schedule_dates[b]['date']);
                                if (schedule_date == 1) {
                                    var id = schedule_dates[b]['id'];
                                    var file = schedule_dates[b]['file'];
                                    var type = schedule_dates[b]['type'];
                                    var total_count = schedule_dates[b]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    b = schedule_dates.length;
                                }
                            }
                            if(set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1"><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1"><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                    }
                    if (first_row == 7) {
                        $('#show_date').append('</tr><tr>');
                    }
                    break;
                } else {
                    if (set_year > current_year) {
                        if (future_dates.length > 0) {
                            var set_media = 0;
                            for (var y = 0; y < future_dates.length; y++) {
                                var schedule_date = parseInt(future_dates[y][0].date);
                                if (schedule_date == 1) {
                                    var id = future_dates[y][0].id;
                                    var file = future_dates[y][0].file;
                                    var type = future_dates[y][0].type;
                                    var total_count = future_dates[y][0].total_count;
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="mediaOption('+ id +', 1)"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    y = future_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="1" onclick="selectMedia(1)"><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                    if (set_year <= current_year) {
                        if (future_dates.length > 0) {
                            var set_media = 0;
                            for (var y = 0; y < future_dates.length; y++) {
                                var schedule_date = parseInt(future_dates[y][0].date);
                                if (schedule_date == 1) {
                                    var id = future_dates[y][0].id;
                                    var file = future_dates[y][0].file;
                                    var type = future_dates[y][0].type;
                                    var total_count = future_dates[y][0].total_count;
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;1<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="1" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;1'+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    y = future_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td><p class="">&nbsp; &nbsp;1</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td><p class="">&nbsp; &nbsp;1</p></td>'
                            );
                        }
                        if (first_row == 7) {
                            $('#show_date').append('</tr><tr>');
                        }
                        break;
                    }
                }
            } else {
                $('#show_date').append('<td></td>');
            }
        }
        var row_break = first_row;
        for (var i = 2; i <= days_31; i++) {
            row_break++;
            if (set_month == current_month && set_year == current_year) {
                if (current_date == i) {
                    if (schedule_dates.length > 0) {
                        var set_media = 0;
                        for (var j = 0; j < schedule_dates.length; j++) {
                            var schedule_date = parseInt(schedule_dates[j]['date']);
                            if (schedule_date == current_date) {
                                var id = schedule_dates[j]['id'];
                                var file = schedule_dates[j]['file'];
                                var type = schedule_dates[j]['type'];
                                var total_count = schedule_dates[j]['total_count'];
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                j = schedule_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="event-active">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="event-active">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                } else {
                    if (i > current_date) {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var k = 0; k < schedule_dates.length; k++) {
                                var schedule_date = parseInt(schedule_dates[k]['date']);
                                if (schedule_date == i) {
                                    var id = schedule_dates[k]['id'];
                                    var file = schedule_dates[k]['file'];
                                    var type = schedule_dates[k]['type'];
                                    var total_count = schedule_dates[k]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    k = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        if (schedule_dates.length > 0) {
                            var set_media = 0;
                            for (var n = 0; n < schedule_dates.length; n++) {
                                var schedule_date = parseInt(schedule_dates[n]['date']);
                                if (schedule_date == i) {
                                    var id = schedule_dates[n]['id'];
                                    var file = schedule_dates[n]['file'];
                                    var type = schedule_dates[n]['type'];
                                    var total_count = schedule_dates[n]['total_count'];
                                    var for_multi = '/public/assets/images/multi.png';
                                    var multi_file_icon = '';
                                    if (total_count > 1) {
                                        multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                    }
                                    if (type == 'video') {
                                        var my_file = file.split(".");
                                        var set_format = '';
                                        var ios = '#t=0.001';
                                        if (my_file[1] == 'mov') {
                                            set_format = 'video/mp4';
                                        } else {
                                            set_format = 'video/' + my_file[1];
                                        }
                                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                        );
                                    } else if (type == 'audio') {
                                        var file_url = '/public/assets/images/audio-pop.png';
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    } else {
                                        $('#show_date').append(
                                            '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                        );
                                    }
                                    set_media++;
                                    n = schedule_dates.length;
                                }
                            }
                            if (set_media == 0) {
                                $('#show_date').append(
                                    '<td id="'+ i +'" onclick="checkDate()"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                                );
                            }
                        } else {
                            $('#show_date').append(
                                '<td id="'+ i +'" onclick="checkDate()"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    }
                }
            } else {
                if (set_year > current_year) {
                    if (future_dates.length > 0) {
                        var set_media = 0;
                        for (var y = 0; y < future_dates.length; y++) {
                            if (future_dates[y][0].date == i) {
                                var id = future_dates[y][0].id;
                                var file = future_dates[y][0].file;
                                var type = future_dates[y][0].type;
                                var total_count = future_dates[y][0].total_count;
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="mediaOption('+ id +', '+ i +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                y = future_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td id="' + i + '" onclick="selectMedia(' + i + ')"><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                } else {
                    if (future_dates.length > 0) {
                        var set_media = 0;
                        for (var y = 0; y < future_dates.length; y++) {
                            if (future_dates[y][0].date == i) {
                                var id = future_dates[y][0].id;
                                var file = future_dates[y][0].file;
                                var type = future_dates[y][0].type;
                                var total_count = future_dates[y][0].total_count;
                                var for_multi = '/public/assets/images/multi.png';
                                var multi_file_icon = '';
                                if (total_count > 1) {
                                    multi_file_icon = '<a><img class="multi" src="'+ base_url + for_multi +'" /></a>';
                                }
                                if (type == 'video') {
                                    var my_file = file.split(".");
                                    var set_format = '';
                                    var ios = '#t=0.001';
                                    if (my_file[1] == 'mov') {
                                        set_format = 'video/mp4';
                                    } else {
                                        set_format = 'video/' + my_file[1];
                                    }
                                    var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white">&nbsp; &nbsp;'+ i +'<video class="example-image video-calendar"><source src="'+ base_path + file + ios +'" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a>'+ multi_file_icon +'</p></td>'
                                    );
                                } else if (type == 'audio') {
                                    var file_url = '/public/assets/images/audio-pop.png';
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                } else {
                                    $('#show_date').append(
                                        '<td id="'+ i +'" onclick="actionMedia('+ id +')"><p class="cl-white" style="background-image: url(' + base_path + file + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ i +''+ multi_file_icon +'</p></td>'
                                    );
                                }
                                set_media++;
                                y = future_dates.length;
                            }
                        }
                        if (set_media == 0) {
                            $('#show_date').append(
                                '<td><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                            );
                        }
                    } else {
                        $('#show_date').append(
                            '<td><p class="">&nbsp; &nbsp;' + i + '</p></td>'
                        );
                    }
                }
            }
            if (row_break == 7 || row_break == 14 || row_break == 21 || row_break == 28 || row_break == 35) {
                $('#show_date').append('</tr><tr>');
            }
        }
        $('#show_date').append('</tr>');
    }

    function checkDate() {
        $("#showMsg").modal("show");
    }

    function mediaOption(id, date) {
        var temp_media_id = document.getElementById('temp_media_id');
        var temp_date = document.getElementById('temp_date');
        temp_media_id.value = id;
        temp_date.value = date;
        $("#scheduleOption").modal("show");
    }

    function yourSchedule(current) {
        var temp_media_id = document.getElementById('temp_media_id').value;
        var temp_date = document.getElementById('temp_date').value;
        $("#scheduleOption").modal("hide");
        if (current == 'add_new') {
            selectMedia(temp_date);
        } else if (current == 'view_details') {
            actionMedia(temp_media_id);
        }
    }

    function closeScheduleOption() {
        $("#scheduleOption").modal("hide");
    }

    function actionMedia(current) {
        var base_path = '<?= $file_path ?>';
        var base_url = '<?= $base_url ?>';
        var schedule_media = JSON.parse('<?php echo json_encode($schedule_media) ?>');
        var delete_media = document.getElementById('delete_media');
        delete_media.value = current;

        for (var i = 0; i < schedule_media.length; i++) {
            if (current == schedule_media[i].id) {
                var id = schedule_media[i].id;
                var type = schedule_media[i].type;
                var file_name = schedule_media[i].file_name;
                var description = schedule_media[i].description;
                var personal_message = schedule_media[i].message;
                var media_recipients = schedule_media[i].all_recipient;
                var date_time = 'Delivery Date & Time : '+ schedule_media[i].date_time_for_user;
                var date_media = document.getElementById('date_media');
                var media_index = document.getElementById('media_index');
                date_media.value = schedule_media[i].date;
                media_index.value = 0;

                if (type == 'video') {
                    var my_file = file_name.split(".");
                    var set_format = '';
                    var ios = '#t=0.001';
                    if (my_file[1] == 'mov') {
                        set_format = 'video/mp4';
                    } else {
                        set_format = 'video/' + my_file[1];
                    }
                    var media_for_display = '<video id="ban_video" class="tv_video" controls><source src="' + base_path + file_name + ios + '" type="'+ set_format +'" /></video>';
                } else if (type == 'photo') {
                    var media_for_display = '<picture id="ban_image" class="tv_image"><img src="' + base_path + file_name + '" type="image" height="500" width="720" /></picture>';
                } else {
                    var media_for_display = '<audio id="ban_audio" class="tv_audio" controls><source src="' + base_path + file_name + '" type="audio/mp3" /></audio>';
                }

                $('#show_schedule_media').empty();
                $('#show_schedule_media').append(media_for_display);
                if (type == 'photo') {
                    $('#show_schedule_media').append('<div class="">');
                } else {
                    $('#show_schedule_media').append('<div class="mt-3">');
                }
                var schedule_multiple = schedule_media[i].multiple_media;
                var media_no = 1;
                for (var j = 0; j < schedule_multiple.length; j++) {
                    if (schedule_multiple[j].id == id) {
                        $('#show_schedule_media').append('<span class="w3-badge bull bull-active demo w3-border w3-transparent w3-hover-white" onclick="currentDiv('+ media_no +')"></span>');
                    } else {
                        $('#show_schedule_media').append('<span class="w3-badge bull demo w3-border w3-transparent w3-hover-white" onclick="currentDiv('+ media_no +')"></span>');
                    }
                }
                $('#show_schedule_media').append('</div>');

                if (description == 'Not Found') {
                    description = '';
                }
                if (personal_message == 'Not Found') {
                    personal_message = '';
                }

                $('#media_date_time').empty();
                $('#media_date_time').append(date_time);
                $('#media_description').empty();
                $('#media_description').append(description);
                $('#media_personal_message').empty();
                $('#media_personal_message').append(personal_message);

                if (media_recipients != null) {
                    $('#schedule_recipient').empty();
                    for (var j = 0; j < media_recipients.length; j++) {
                        var name = media_recipients[j].name;
                        var last_name = media_recipients[j].last_name;
                        var profile_image = media_recipients[j].profile_image;
                        var recipient = '<div class="rec-images text-center px-2"><img src="' + base_url + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3">' + name + '</p></div>';
                        $('#schedule_recipient').append(recipient);
                    }
                }
                i = schedule_media.length;
            }
        }
        $("#myScheduleMedia").modal("show");
    }

    function closeScheduleMedia() {
        $("#myScheduleMedia").modal("hide");
    }

    function changeMedia(current) {
        var base_path = '<?= $file_path ?>';
        var base_url = '<?= $base_url ?>';
        var schedule_media = JSON.parse('<?php echo json_encode($schedule_media) ?>');
        var date_media = document.getElementById('date_media').value;

        for (var i = 0; i < schedule_media.length; i++) {
            if (date_media == schedule_media[i].date) {
                var total_media = schedule_media[i].multiple_media;
                if (total_media.length > 1) {
                    var media_index = document.getElementById('media_index');
                    var current_index = media_index.value;
                    if (current == 'previous') {
                        if (current_index != 0) {
                            current_index--;
                        }
                    }
                    if (current == 'next') {
                        if (current_index < total_media.length - 1) {
                            current_index++;
                        }
                    }

                    media_index.value = current_index;
                    var id = total_media[current_index].id;
                    var type = total_media[current_index].type;
                    var file_name = total_media[current_index].file_name;
                    var description = total_media[current_index].description;
                    var personal_message = total_media[current_index].message;
                    var media_recipients = total_media[current_index].media_recipients;
                    var date_time = 'Delivery Date & Time : '+ total_media[current_index].date_time_for_user;
                    var delete_media = document.getElementById('delete_media');
                    delete_media.value = id;

                    if (type == 'video') {
                        var my_file = file_name.split(".");
                        var set_format = '';
                        var ios = '#t=0.001';
                        if (my_file[1] == 'mov') {
                            set_format = 'video/mp4';
                        } else {
                            set_format = 'video/' + my_file[1];
                        }
                        var media_for_display = '<video id="ban_video" class="tv_video" controls><source src="' + base_path + file_name + ios + '" type="'+ set_format +'" /></video>';
                    } else if (type == 'photo') {
                        var media_for_display = '<picture id="ban_image" class="tv_image"><img src="' + base_path + file_name + '" type="image" height="500" width="720" /></picture>';
                    } else {
                        var media_for_display = '<audio id="ban_audio" class="tv_audio" controls><source src="' + base_path + file_name + '" type="audio/mp3" /></audio>';
                    }

                    $('#show_schedule_media').empty();
                    $('#show_schedule_media').append(media_for_display);
                    if (type == 'photo') {
                        $('#show_schedule_media').append('<div class="">');
                    } else {
                        $('#show_schedule_media').append('<div class="mt-3">');
                    }
                    var schedule_multiple = schedule_media[i].multiple_media;
                    var media_no = 1;
                    for (var j = 0; j < schedule_multiple.length; j++) {
                        if (schedule_multiple[j].id == id) {
                            $('#show_schedule_media').append('<span class="w3-badge bull bull-active demo w3-border w3-transparent w3-hover-white" onclick="currentDiv('+ media_no +')"></span>');
                        } else {
                            $('#show_schedule_media').append('<span class="w3-badge bull demo w3-border w3-transparent w3-hover-white" onclick="currentDiv('+ media_no +')"></span>');
                        }
                    }
                    $('#show_schedule_media').append('</div>');

                    if (description == 'Not Found') {
                        description = '';
                    }
                    if (personal_message == 'Not Found') {
                        personal_message = '';
                    }

                    $('#media_date_time').empty();
                    $('#media_date_time').append(date_time);
                    $('#media_description').empty();
                    $('#media_description').append(description);
                    $('#media_personal_message').empty();
                    $('#media_personal_message').append(personal_message);

                    if (media_recipients != null) {
                        $('#schedule_recipient').empty();
                        for (var j = 0; j < media_recipients.length; j++) {
                            var name = media_recipients[j].name;
                            var last_name = media_recipients[j].last_name;
                            var profile_image = media_recipients[j].profile_image;
                            var recipient = '<div class="rec-images text-center px-2"><img src="' + base_url + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3">' + name + '</p></div>';
                            $('#schedule_recipient').append(recipient);
                        }
                    }
                }
                i = schedule_media.length;
            }
        }
        $("#myScheduleMedia").modal("show");
    }

    function selectMedia(current) {
        var show_media = document.getElementById('show_media');
        var media_date = document.getElementById('media_date');
        show_media.value = current;
        media_date.value = current;
        $("#myMedia").modal("show");
    }

    function closeMedia() {
        $("#myMedia").modal("hide");
    }

    function deleteMedia(current) {
        var id = document.getElementById('delete_media').value;
        var base_url = '<?= $base_url ?>';
        var set_path = base_url + '/schedule-media/delete-schedule/'+ id;
        var element = document.getElementById('delete_schedule');
        element.href = set_path;
        $("#delete").modal("show");
    }

    function mediaSelect(media_id) {
        $("#myMedia").modal("hide");
        var show_media = document.getElementById('show_media').value;
        var selected_file = document.getElementById('selected_file');
        var base_path = '<?= $file_path ?>';
        var base_url = '<?= $base_url ?>';
        var all_media = JSON.parse('<?php echo json_encode($all_media) ?>');
        var user_recipents = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        selected_file.value = media_id;

        if (all_media != null) {
            var all_media_len = all_media.length;
        } else {
            var all_media_len = 0;
        }

        if (all_media_len > 0) {
            for (var i = 0; i < all_media_len; i++) {
                if (all_media[i].id == media_id) {
                    var file_name = all_media[i].file_name;
                    var type = all_media[i].type;
                    var media_file = '';
                    var for_multi = '/public/assets/images/multi.png';

                    if (type == 'video') {
                        var my_file = file_name.split(".");
                        var set_format = '';
                        var ios = '#t=0.001';
                        if (my_file[1] == 'mov') {
                            set_format = 'video/mp4';
                        } else {
                            set_format = 'video/' + my_file[1];
                        }
                        var for_video = '/public/assets/images/Exm-Buttons-Play.png';
                        media_file = '<p class="cl-white">&nbsp; &nbsp;'+ show_media +'<video class="example-image video-calendar"><source src="' + base_path + file_name + ios + '" type="'+ set_format +'"></video><a><img class="img-calendar-play" src="'+ base_url + for_video +'" /></a></p>';
                    } else if (type == 'audio') {
                        var file_url = '/public/assets/images/audio-pop.png';
                        media_file = '<p class="cl-white" style="background-image: url(' + base_url + file_url + '); background-size: 40px; cursor:pointer; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ show_media +'</p>';
                    } else {
                        media_file = '<p class="cl-white" style="background-image: url(' + base_path + file_name + '); background-size: cover; background-repeat: no-repeat;  background-position: center;">&nbsp; &nbsp;'+ show_media +'</p>';
                    }
                    
                    var my_selected = document.getElementById(show_media);
                    var set_width = my_selected.setAttribute('width', '170');
                    var set_height = my_selected.setAttribute('height', '40');
                    var last_selected_media = document.getElementById('last_selected_media');
                    var check_media = last_selected_media.value;
                    if (check_media != '' && check_media != show_media) {
                        var date_replace = '<p class="">&nbsp; &nbsp;' + check_media + '</p>';
                        $('#'+ check_media).empty();
                        $('#'+ check_media).append(date_replace);
                    }
                    $('#'+ show_media).empty();
                    $('#'+ show_media).append(media_file);
                    last_selected_media.value = show_media;

                    const media_recipient = [];
                    if (all_media[i].all_recipient != null) {
                        var all_recipient_len = all_media[i].all_recipient.length;
                        for (var j = 0; j < all_recipient_len; j++) {
                            var recipient = all_media[i].all_recipient[j];
                            media_recipient.push(recipient.recipient_id);
                        }
                    }

                    var user_recipient_len = user_recipents.length;
                    var all_recipient = '<div class="rec-images text-center px-2"><img src="'+ base_url + '/public/media/image/all-users.png"><p class="cl-white sel-text mt-3"><input class="form-check-input" type="checkbox" id="all_recipient" name="all_recipient" value="all recipient" onclick="selectAllRecipient(this)"> All</p></div>';

                    $("#show_recipient").empty();
                    $("#show_recipient").append(all_recipient);

                    for (var k = 0; k < user_recipient_len; k++) {
                        var recipient_id = user_recipents[k].recipient_id;
                        var name = user_recipents[k].name;
                        var profile_image = user_recipents[k].profile_image;
                        if (media_recipient.includes(user_recipents[k].recipient_id)) {
                            var single_recipient = '<div class="rec-images text-center px-2"><img src="' + base_url + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="'+ recipient_id +'" checked> ' + name + '</p></div>';
                        } else {
                            var single_recipient = '<div class="rec-images text-center px-2"><img src="' + base_url + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="recipient_id[]" value="'+ recipient_id +'"> ' + name + '</p></div>';
                        }
                        $("#show_recipient").append(single_recipient);
                    }
                }
            }
        }
    }

    function timeFormat(current) {
        if (current.value == 24) {
            $('#day_night').hide();
            $('#pick_hours').empty();
            var o = new Option("Hours", "");
            $("#pick_hours").append(o);
            for (var i = 1; i < 24; i++) {
                var pick_hour = i;
                if (i < 10) {
                    pick_hour = '0' + i;
                }
                var o = new Option(pick_hour, pick_hour);
                $("#pick_hours").append(o);
            }
        } else {
            $('#day_night').show();
            $('#pick_hours').empty();
            var o = new Option("Hours", "");
            $("#pick_hours").append(o);
            for (var i = 1; i <= 12; i++) {
                var pick_hour = i;
                if (i < 10) {
                    pick_hour = '0' + i;
                }
                var o = new Option(pick_hour, pick_hour);
                $("#pick_hours").append(o);
            }
        }
    }

    function recipentByName() {
        var obj = JSON.parse('<?php echo json_encode($user_recipents) ?>');
        var base_path = '<?= $base_url ?>';
        var recipent_name = document.getElementById('name').value;
        var div_recipient = $('#show_recipient');
        var for_recipient_id = 'recipient_id[]';
        var for_all_recipient = 'all_recipient';

        if (obj != null) {
            len = obj.length;
        }

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

                        var recipent = '<div class="col-lg-2 col-4 rec-images"><img src="' + base_path + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="'+ recipient_id +'"> ' + name + '</p></div>';

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

                var recipent = '<div class="col-lg-2 col-4 rec-images"><img src="' + base_path + profile_image + '" class="delivey-images mx-2"><p class="cl-white sel-text mt-3"><input class="form-check-input user-recipient" type="checkbox" name="' + for_recipient_id + '" value="'+ recipient_id +'"> ' + name + '</p></div>';

                div_recipient.append(recipent);
            }
        }
    }

    function selectAllRecipient(current) {
        if (current.id == 'all_recipient') {
            var inputs = document.querySelectorAll('.user-recipient');
        }
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

    function uploadType(current) {
        var upload_type = document.getElementById('upload_type');
        upload_type.value = current;
        $("#first_form").click()
    }

    function selectTimezone() {
        var select = document.getElementById('pick_timezone');
        var option = select.options[select.selectedIndex];
        var selected_timezone = option.value;
        var timezone = selected_timezone.split("/");
        var base_url = '<?= $base_url ?>';

        $.ajax({
            url: base_url + '/schedule-timezone/' + selected_timezone,
            type: 'get',
            success: function(response) {
                if (response.message == 'success') {
                    var timezone_minutes = document.getElementById('timezone_minutes');
                    var timezone_hours = document.getElementById('timezone_hours');
                    var timezone_date = document.getElementById('timezone_date');
                    var timezone_month = document.getElementById('timezone_month');
                    var timezone_year = document.getElementById('timezone_year');
                    timezone_minutes.value = response.minutes;
                    timezone_hours.value = response.hours;
                    timezone_date.value = response.date;
                    timezone_month.value = response.month;
                    timezone_year.value = response.year;
                }
            }
        });
    }

    function validateForm() {
        var selected_file = document.getElementById('selected_file').value;
        var inputs = document.querySelectorAll('.user-recipient');
        var selected = 0;
        var recipient_msg = '<span class="cl-white">Please select atleast one recipient!</span>';
        var media_msg = '<span class="cl-white">Please select media from given calendar!</span>';
        var time_msg = '<span class="cl-white">Please select greater then current time!</span>';
        var timezone_date = document.getElementById('timezone_date').value;
        var timezone_hours = document.getElementById('timezone_hours').value;
        var timezone_minutes = document.getElementById('timezone_minutes').value;
        var media_date = document.getElementById('media_date').value;
        var format_12 = document.getElementById('format_12');
        var format_24 = document.getElementById('format_24');
        var pick_hours = document.getElementById('pick_hours').value;
        var pick_minutes = document.getElementById('pick_minutes').value;

        if (timezone_date == '') {
            var date = '<?= $date ?>';
            var hours = '<?= $hours ?>';
            var minutes = '<?= $minutes ?>';
        } else {
            var date = timezone_date;
            var hours = timezone_hours;
            var minutes = timezone_minutes;
        }

        if (date == media_date) {
            if (format_12.checked == true) {
                var day_night = document.getElementById('day_night').value;
                var set_pick_hour = parseInt(pick_hours);
                if (day_night == 'PM') {
                    pick_hours = set_pick_hour + 12;
                }
            }
            if (format_24.checked == true) {
                var pick_hours = parseInt(pick_hours);
            }
            if (pick_hours < hours) {
                $('#show_time_msg').empty();
                $("#show_time_msg").append(time_msg);
                return false;
            }
            if (pick_hours == hours) {
                if (pick_minutes <= minutes) {
                    $('#show_time_msg').empty();
                    $("#show_time_msg").append(time_msg);
                    return false;
                }
            }
        }
        $('#show_time_msg').empty();

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].checked == true) {
                selected = 1;
                i = inputs.length;
            }
        }
        if (selected == 0) {
            $('#show_recipient_msg').empty();
            $("#show_recipient_msg").append(recipient_msg);
            return false;
        }
        $('#show_recipient_msg').empty();

        if (selected_file == '') {
            $('#show_media_msg').empty();
            $("#show_media_msg").append(media_msg);
            return false;
        }
        $('#show_media_msg').empty();
        return true;
    }
</script>

<script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function currentDiv(n) {
        showDivs(slideIndex = n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        if (n > x.length) {slideIndex = 1}
        if (n < 1) {slideIndex = x.length}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-white", "");
        }
        x[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " w3-white";
    }
</script>