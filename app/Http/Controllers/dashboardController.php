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
    public function splash(){
        return view('frontend.splash.index');
    }

}
