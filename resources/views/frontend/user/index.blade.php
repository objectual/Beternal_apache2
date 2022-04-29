@extends("frontend.layouts.layout")
@section("title","My Profile")
@section("content")
    <div class="container-fluid bg-create account-back scroll-height-mobile mobile-padding">
        <div class="scroll-div">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 mt-5 mb-3 edit text-center">
                    <div class="row">
                        <div class="col-lg-6 col-10 text-start">
                            <p class="acc-black text-white">
                                ACCOUNT PROFILE
                            </p>
                        </div>
                        <div class="col-lg-6 col-2 text-end">
                            <a href="{{ route('user.profile.edit') }}" class="icon-edit">
                                <img class="mt-2 img-edit" src="{{ asset('/public/assets/images/edit.png')}}"/>
                            </a>
                        </div>
                    </div>
                    <img class="acc-img" style="border-radius: 100%;" src="@if(Auth::user()->profile_image){{ asset( Auth::user()->profile_image )}}@else{{ asset('/public/assets/images/recipent.png') }}@endif" />
                    <p class="head1">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                    <p class="head2">{{ Auth::user()->email }}</p>
                    <p class="mb-2 head3">{{ Auth::user()->phone }}</p>
                    <a href="{{ route('user.subscription') }}" class="btn btn-primary arial-bold btn-upgrade">
                    UPGRADE
                    </a>
                </div>

                <div class="pt-5 newbuttoons">
                    <div class="col-12">
                        <a href="{{ route('user.notifications') }}"">
                            <p class="m-0" style="float: left">
                                  <!-- <img src="{{ asset('/public/assets/images/notification.svg') }}"  class="profile-icon" />  -->
                                <span style="font-size:18px; font-weight: bold" >NOTIFICATION</span>
                            </p>
                        </a>
                        <a href="{{ route('privacy-policy') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/privacy-policy.svg') }}" class="profile-icon" />  -->
                                <span style="font-size:18px; font-weight: bold">PRIVACY POLICY</span>
                            </p>
                        </a>
                        <a href="{{ route('term-and-conditions') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/terms.svg') }}" class="profile-icon" />  -->
                                <span class="small-terms-head" style="font-size:18px; font-weight: bold">TERMS + CONDITIONS</span>
                            </p>
                        </a>
                        <a href="{{ route('help-and-support') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/support.svg') }}" class="profile-icon" />  -->
                                <span style="font-size:18px; font-weight: bold">SUPPORT/HELP</span>
                            </p>
                        </a>
                        <!-- <a href="#">
                            <p class="m-0" style="color: black; float: left">
                                <img src="./images/team.svg" class="profile-icon" /> 
                                <span style="font-size:18px; font-weight: bold">OUR TEAM</span>
                            </p>
                        </a> -->
                        <a href="{{ route('our-solution') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/solution.svg') }}" class="profile-icon" />  -->
                                <span style="font-size:18px; font-weight: bold">OUR SOLUTION</span>
                            </p>
                        </a>
                        <a href="{{ route('contact-us') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/contact.svg') }}" class="profile-icon" />  -->
                                <span class="small-terms-head" style="font-size:18px; font-weight: bold">CONTACT US</span>
                            </p>
                        </a> 
                        <a href="{{ route('splash') }}">
                            <p class="m-0" style="float: left">
                                <!-- <img src="{{ asset('/public/assets/images/about.svg') }}" class="profile-icon" /> -->
                                <span style="font-size:18px; font-weight: bold">ABOUT US</span>
                            </p>
                        </a>
                        <!-- <a href="">
                            <p class="m-0" style="color: black; float: left">
                                <img src="{{ asset('/public/assets/images/notification.svg') }}" class="profile-icon" /> 
                                <span style="font-size:18px; font-weight: bold; color: red">LOGOUT</span>
                            </p>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>  
    </div>
@endsection