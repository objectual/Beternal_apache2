<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function media()
    {
        return view('frontend.media.addMedia');
    }

    public function captureVideo()
    {
        return view('frontend.media.captureVideo');
    }

    public function captureAudio()
    {
        return view('frontend.media.captureAudio');
    }

    public function captureImage()
    {
        return view('frontend.media.captureImage');
    }

    public function myMedia()
    {
        return view('frontend.media.myMedia');
    }

    public function legacy()
    {
        return view('frontend.legacy.legacy');
    }

    public function scheduleMedia()
    {
        return view('frontend.schedule.scheduleMedia');
    }
}
