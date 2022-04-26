<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $title = "SUBMIT PAYMENT";
        return view('frontend.payments.payment', compact('title'));
    }

    public function paymentSuccessfull()
    {
        $title = "PAYMENT SUCCESSFULL";
        return view('frontend.payments.paymentSuccessfull', compact('title'));
    }
}
