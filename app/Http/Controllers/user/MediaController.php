<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;
use App\Models\UserRecipient;
use App\Models\Group;
use App\Models\ShareMedia;
use App\Models\ShareMediaGroup;
use Storage;

class MediaController extends Controller
{
    public function media()
    {
        return view('frontend.media.addMedia');
    }

    public function captureVideo()
    {
        $id = Auth::user()->id;

        $user_recipents =  UserRecipient::where('user_id', $id)
        ->join('users', 'user_recipients.recipient_id', '=', 'users.id')
        ->get(['user_recipients.recipient_id', 'users.name', 'users.last_name', 'users.profile_image']);

        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);

        return view('frontend.media.captureVideo', compact('user_recipents', 'groups'));
    }

    public function uploadVideo(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|alpha|max:255',
            'description' => 'required|string|alpha|max:255',
            'file_name' => 'required|file|mimetypes:video/mp4',
        ]);

        $video = new Media();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->path = 'test';
        if ($request->hasFile('file_name')) {
            $path = $request->file('file_name')->store('videos', ['disk' => 'my_files']);
            $video->file_name = $path;
        }
        $video->type = 'video';
        $video->user_id = Auth::user()->id;
        $video->save();
        
        if($video) {
            if (!(empty($request->recipient_id))) {
                if (count($request->recipient_id) > 0) {
                    for ($i = 0; $i < count($request->recipient_id); $i++) {
                        $share_video = new ShareMedia();
                        $share_video->media_id = $video->id;
                        $share_video->recipient_id = $request->recipient_id[$i];
                        $share_video->save();
                    }
                }
            }
            if (!(empty($request->group_id))) {
                $share_video_in_group = new ShareMediaGroup();
                $share_video_in_group->media_id = $video->id;
                $share_video_in_group->group_id = $request->group_id;
                $share_video_in_group->save();
            }
            return redirect()->route('user.medias.my-media');
        } else {
            return redirect()->route('user.medias.capture-video');
        }
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
        $videos = Media::where(['type' => 'video', 'user_id' => Auth::user()->id])
        ->get(['*']);
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
