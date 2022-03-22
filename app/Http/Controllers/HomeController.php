<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contactUs()
    {
        return view('frontend.contactUs');
    }

    public function aboutUs()
    {
        return view('frontend.aboutUs');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacyPolicy');
    }

    public function ourTeam()
    {
        return view('frontend.ourTeam');
    }

    public function ourSolution()
    {
        return view('frontend.ourSolution');
    }

    public function termAndConditions()
    {
        return view('frontend.termAndConditions');
    }

    public function helpAndSupport()
    {
        return view('frontend.helpAndSupport');
    }
}
