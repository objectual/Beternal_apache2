<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $title = "NOTIFICATION";
        return view('frontend.notifications.notifications', compact('title'));
    }
}
