<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class PaymentController extends Controller
{
    public function payment()
    {
        $title = "SUBMIT PAYMENT";
        $countries =  Country::all();
        return view('frontend.payments.payment', compact('title', 'countries'));
    }

    public function paymentSuccessfull()
    {
        $title = "PAYMENT SUCCESSFULL";
        return view('frontend.payments.paymentSuccessfull', compact('title'));
    }
}
