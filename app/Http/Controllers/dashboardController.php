<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class dashboardController extends Controller
{
    public function dashboard(){
        if (session()->get('user_timezone') == null) {
            $title = "TIMEZONE";
            return view('frontend.userTimezone', compact('title'));
        } else {
            $title = "DASHBOARD";
            return view('frontend.dashboard', compact('title'));
        }
    }

}
