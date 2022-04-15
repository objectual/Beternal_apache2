<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contactUs()
    {
        return view('frontend.contactUs');
    }

    public function splash()
    {
        return view('frontend.splash.index');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacyPolicy');
    }

    public function ourTeam()
    {
        return redirect('/');
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

    public function forgetCode()
    {
        return view('frontend.forgetCode');
    }

    public function successSignup()
    {
        return view('frontend.successSignup');
    }

    public function survey()
    {
        return view('frontend.survey');
    }
}
