<?php

use App\Models\User;
use App\Models\UserRecipient;
  
    function userDetails($id) {
        $user = User::where('users.id', $id)
        ->join('user_roles', 'users.role_id', '=', 'user_roles.id')
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->join('countries', 'users.country_id', '=', 'countries.id')
        ->join('state_province', 'users.state_province_id', '=', 'state_province.id')
        ->join('cities', 'users.city_id', '=', 'cities.id')
        ->get(['users.*', 'user_roles.role_name', 'plans.title', 'countries.country_name', 'state_province.name as province_name', 'cities.city_name']);
        return $user;    
    }

    function userRecipients($id) {
        $user_recipents =  UserRecipient::where('user_id', $id)
        ->join('users', 'user_recipients.recipient_id', '=', 'users.id')
        ->get(['user_recipients.recipient_id', 'users.name', 'users.last_name', 'users.profile_image']);
        return $user_recipents;
    }
   
?>