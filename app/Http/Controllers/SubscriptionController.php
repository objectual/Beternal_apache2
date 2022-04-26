<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $title = "TIERS";
        return view('frontend.subscription.plans', compact('title'));
    }

    public function subscriptionSuccessfull()
    {
        $title = "SUBSCRIPTION SUCCESSFULL";
        return view('frontend.subscription.subscriptionSuccessfull', compact('title'));
    }
}
