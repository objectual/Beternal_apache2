<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        return view('frontend.payments.payment');
    }

    public function paymentSuccessfull()
    {
        return view('frontend.payments.paymentSuccessfull');
    }
}
