<?php

use App\Models\User;
use App\Models\UserRecipient;
use App\Models\Media;
use App\Models\City;
use App\Models\StateProvince;
  
    function userDetails($id) {
        $user = User::where('users.id', $id)
        ->join('user_roles', 'users.role_id', '=', 'user_roles.id')
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('countries', 'users.country_id', '=', 'countries.id')
        ->join('state_province', 'users.state_province_id', '=', 'state_province.id')
        ->join('cities', 'users.city_id', '=', 'cities.id')
        ->get(['users.*', 'user_roles.role_name', 'plans.title', 'countries.country_name', 'countries.postal_code_format', 'state_province.name as province_name', 'cities.city_name']);
        return $user;    
    }

    function userRecipients($id) {
        $user_recipents =  UserRecipient::where('user_id', $id)
        ->get(['recipient_id', 'name', 'last_name', 'profile_image']);
        return $user_recipents;
    }

    function userAudioVideoCount($id) {
        $audio_video_count =  Media::where('user_id', $id)->whereIn('type', ['video', 'audio'])
        ->count();
        return $audio_video_count;
    }

    function activeStateProvince() {
        $state_provinces = StateProvince::where('status', 1)->get(['id','name','country_id']);
        return $state_provinces;
    }

    function activeCities() {
        $cities = City::where('status', 1)->get(['id','city_name','state_province_id']);
        return $cities;
    }

    function selectedStateProvince($id) {
        $state_provinces = StateProvince::where('country_id', $id)->get(['id', 'name']);
        return $state_provinces;
    }

    function selectedCities($id) {
        $cities = City::where('state_province_id', $id)->get(['id', 'city_name']);
        return $cities;
    }
