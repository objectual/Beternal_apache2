@extends("frontend.layouts.layout")
@section("title","Delivery")
@section("content")
@php
    $mydate = getdate(date("U"));
    $day = "$mydate[weekday]";
    $month = "$mydate[month]";
    $date = "$mydate[mday]";
    $year = "$mydate[year]";
@endphp
<div class="container-fluid bg-create delivery-padding bg-calendar">
    <div class="scroll-div">
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
                                    <p class="cl-white">JAN</p>
                                </div>
                                <div class="carousel-item">
                                    <p>FEB</p>
                                </div>
                                <div class="carousel-item">
                                    <p>MAR</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <div id="carouselExampleControls mob-col" class="carousel slide year-slide" data-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="cl-white">2022</p>
                                </div>
                                <div class="carousel-item">
                                    <p>2020</p>
                                </div>
                                <div class="carousel-item">
                                    <p>2020</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row px-5 p-0-m">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="mb-1 w-100 delivery-calendar">
                                <thead>
                                    <tr>
                                        <td class="calendar-td-head sunday">Sun</td>
                                        <td class="calendar-td-head weekdays-back">Mon</td>
                                        <td class="calendar-td-head weekdays-back">Tue</td>
                                        <td class="calendar-td-head weekdays-back">Wed</td>
                                        <td class="calendar-td-head weekdays-back">Thu</td>
                                        <td class="calendar-td-head weekdays-back">Fri</td>
                                        <td class="calendar-td-head weekdays-back">Sat</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="">26</p>
                                        </td>
                                        <td>
                                            <p class="">27</p>
                                        </td>
                                        <td>
                                            <p class="">28</p>
                                        </td>
                                        <td>
                                            <p class="">29</p>
                                        </td>
                                        <td>
                                            <p class="">30</p>
                                        </td>
                                        <td>
                                            <p class="">1</p>
                                        </td>
                                        <td>
                                            <p class="">2</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="">3</p>
                                        </td>
                                        <td>
                                            <p class="">4</p>
                                        </td>
                                        <td>
                                            <p class="">5</p>
                                        </td>
                                        <td>
                                            <p class="event-active">6</p>
                                        </td>
                                        <td>
                                            <p class="">7</p>
                                        </td>
                                        <td>
                                            <p class="">8</p>
                                        </td>

                                        <td>
                                            <p class="">9</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="cl-white" style="background-image: url('{{ asset('/public/assets/images/christopher-campbell-rDEOVtE7vOs-unsplash.jpg') }}'); background-size: cover;">10</p>
                                        </td>
                                        <td>
                                            <p class="">11</p>
                                        </td>
                                        <td>
                                            <p class="">12</p>
                                        </td>
                                        <td>
                                            <p class="event-active">13</p>
                                        </td>
                                        <td>
                                            <p class="">14</p>
                                        </td>
                                        <td>
                                            <p class="">15</p>
                                        </td>
                                        <td>
                                            <p class="">16</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="">17</p>
                                        </td>
                                        <td>
                                            <p class="">18</p>
                                        </td>
                                        <td>
                                            <p class="">19</p>
                                        </td>
                                        <td>
                                            <p class="event-active">20</p>
                                        </td>
                                        <td>
                                            <p class="">21</p>
                                        </td>
                                        <td>
                                            <p class="">22</p>
                                        </td>
                                        <td>
                                            <p class="">23</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="">24</p>
                                        </td>

                                        <td>
                                            <p class="">25</p>
                                        </td>
                                        <td>
                                            <p class="">26</p>
                                        </td>
                                        <td>
                                            <p class="">27</p>
                                        </td>
                                        <td>
                                            <p class="">28</p>
                                        </td>
                                        <td>
                                            <p class="">29</p>
                                        </td>
                                        <td>
                                            <p class="">30</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="">31</p>
                                        </td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
                                    <span class="time mt-3">Time <span class="time-detail">Newfoundland (GMT-3:30)</span></span>
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
@endsection

<script>
    var today = new Date();
    // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var current_year = today.getFullYear();
    var current_month = today.toLocaleString('default', { month: 'long' });
    var current_date = today.getDate();
    alert(current_year);
    alert(current_month);
    alert(current_date);
    $('#month_year').append('<span class="month cl-white mt-3" id="current_month">test</span><br />');
    $('#month_year').append('<span class="year cl-white mt-3" id="current_year">2025</span>');

    // let d = new Date(2020, 08, 21); // 2020-06-21
    // var  months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    // var monthName = months[d.getMonth()-1]; // "July" (or current month)
    // alert(monthName)
</script>