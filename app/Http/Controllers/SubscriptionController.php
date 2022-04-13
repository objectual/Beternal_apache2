<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function plans()
    {
        return view('frontend.subscription.plans');
    }

    public function subscriptionSuccessfull()
    {
        return view('frontend.subscription.subscriptionSuccessfull');
    }
}
