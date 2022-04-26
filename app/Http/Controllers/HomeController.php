<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "HOME";
        return view('frontend.home', compact('title'));
    }

    public function contactUs()
    {
        $title = "CONTACT US";
        return view('frontend.contactUs', compact('title'));
    }

    public function splash()
    {
        $title = "SPLASH";
        return view('frontend.splash.index', compact('title'));
    }

    public function privacyPolicy()
    {
        $title = "PRIVACY POLICY";
        return view('frontend.privacyPolicy', compact('title'));
    }

    public function ourTeam()
    {

        return redirect('/');
    }

    public function ourSolution()
    {
        $title = "OUR SOLUTION";
        return view('frontend.ourSolution', compact('title'));
    }

    public function termAndConditions()
    {
        $title = "TERMS AND CONDITIONS";
        return view('frontend.termAndConditions', compact('title'));
    }

    public function helpAndSupport()
    {
        $title = "HELP AND SUPPORT";
        return view('frontend.helpAndSupport', compact('title'));
    }

    public function forgetCode()
    {
        $title = "FORGET CODE";
        return view('frontend.forgetCode', compact('title'));
    }

    public function successSignup()
    {
        $title = "SUCCESS SIGNUP";
        return view('frontend.successSignup', compact('title'));
    }

    public function survey()
    {
        $title = "HOW ARE WE DOING?";
        return view('frontend.survey', compact('title'));
    }
}
