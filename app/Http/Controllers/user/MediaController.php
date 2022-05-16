<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Media;
use App\Models\UserRecipient;
use App\Models\Group;
use App\Models\ShareMedia;
use App\Models\ShareMediaGroup;
use App\Models\Plan;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function media()
    {
        $title = "CREATE/UPLOAD MEDIA";
        return view('frontend.media.addMedia', compact('title'));
    }

    public function captureVideo()
    {
        $title = "CREATE VIDEO";
        $id = Auth::user()->id;
        $user_recipents =  UserRecipient::where('user_id', $id)
            ->join('users', 'user_recipients.recipient_id', '=', 'users.id')
            ->get(['user_recipients.recipient_id', 'users.name', 'users.last_name', 'users.profile_image']);

        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $plan_details = Plan::where('id', Auth::user()->plan_id)->get(['*']);

        $my_media = userAudioVideoCount($id);

        return view('frontend.media.captureVideo', compact(
            'title',
            'user_recipents',
            'groups',
            'plan_details',
            'my_media'
        ));
    }

    public function captureAudio()
    {
        $title = "CREATE AUDIO";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $plan_details =  Plan::where('id', Auth::user()->plan_id)->get(['*']);

        $my_media = userAudioVideoCount($id);

        return view('frontend.media.captureAudio', compact(
            'title',
            'user_recipents',
            'groups',
            'plan_details',
            'my_media'
        ));
    }

    public function captureImage()
    {
        $title = "CAPTURE IMAGE";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $groups = Group::where('user_id', $id)->get(['id', 'group_title']);
        $plan_details = Plan::where('id', Auth::user()->plan_id)->get(['*']);
        $my_media = Media::where(['type' => 'photo', 'user_id' => $id])->count();

        return view('frontend.media.captureImage', compact(
            'title',
            'user_recipents',
            'groups',
            'plan_details',
            'my_media'
        ));
    }

    public function uploadMedia(Request $request)
    {
        if ($request->media_type == 'video') {
            $this->validate($request, [
                'file_name' => 'required|mimetypes:video/mp4,video/x-flv,video/3gpp,video/quicktime,video/x-msvideo,ideo/x-ms-wmv|max:102400',
            ]);
            $folder = 'videos';
            $route = 'user.medias.capture-video';
        }
        if ($request->media_type == 'audio') {
            $this->validate($request, [
                'file_name' => 'required|file|mimetypes:audio/mpeg,mpga,mp3,mp4,wav',
            ]);
            $folder = 'audios';
            $route = 'user.medias.capture-audio';
        }
        if ($request->media_type == 'photo') {
            $this->validate($request, [
                'file_name' => 'required|image|mimes:jpeg,png,jpg,svg,bmp',
            ]);
            $folder = 'photo';
            $route = 'user.medias.capture-image';
        }

        $media = new Media();
        $media->title = $request->title;
        $media->description = $request->description;
        $media->path = '/';
        if ($request->hasFile('file_name')) {
            // $path = $request->file('file_name')->store($folder, ['disk' => 'my_files']);
            $path = $request->file('file_name')->store($folder, 's3');
            $media->file_name = $path;
        }
        $media->type = $request->media_type;
        $media->user_id = Auth::user()->id;
        $media->save();

        if ($media) {
            if (!(empty($request->recipient_id))) {
                if (count($request->recipient_id) > 0) {
                    for ($i = 0; $i < count($request->recipient_id); $i++) {
                        $share_media = new ShareMedia();
                        $share_media->media_id = $media->id;
                        $share_media->recipient_id = $request->recipient_id[$i];
                        $share_media->save();
                    }
                }
            }
            if (!(empty($request->group_id))) {
                if (count($request->group_id) > 0) {
                    for ($i = 0; $i < count($request->group_id); $i++) {
                        $share_media_in_group = new ShareMediaGroup();
                        $share_media_in_group->media_id = $media->id;
                        $share_media_in_group->group_id = $request->group_id[$i];
                        $share_media_in_group->save();
                    }
                }
            }
            return redirect()->route($route)->with('status', 'Uploaded successfully');
        } else {
            if ($request->media_type == 'video') {
                return redirect()->route('user.medias.capture-video');
            }
            if ($request->media_type == 'audio') {
                return redirect()->route('user.medias.capture-audio');
            } else {
                return redirect()->route('user.medias.capture-image');
            }
        }
    }

    public function store(Request $request)
    {
        $media_type = $request->input('media_type');
        if ($media_type == 'photo') {
            $folder = 'photo/';
            $image = $request->input('image');  // your base64 encoded
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . 'png';
            $file_name = $folder . $imageName;
            // File::put(public_path('photo') . '/' . $imageName, base64_decode($image));
            Storage::disk('s3')->put(('photo') . '/' . $imageName, base64_decode($image));

            $media = new Media();
            $media->title = $request->input('title_2');
            $media->description = $request->input('description_2');
            $media->path = '/';
            $media->file_name = $file_name;
            $media->type = $media_type;
            $media->user_id = Auth::user()->id;
            $media->save();

            if ($media) {
                $recipient = $request->input('recipient_id_2');
                $group = $request->input('group_id_2');
                if ($recipient != null) {
                    if (count($recipient) > 0) {
                        for ($i = 0; $i < count($recipient); $i++) {
                            $share_video = new ShareMedia();
                            $share_video->media_id = $media->id;
                            $share_video->recipient_id = $recipient[$i];
                            $share_video->save();
                        }
                    }
                }
                if ($group != null) {
                    if (count($group) > 0) {
                        for ($i = 0; $i < count($group); $i++) {
                            $share_video_in_group = new ShareMediaGroup();
                            $share_video_in_group->media_id = $media->id;
                            $share_video_in_group->group_id = $group[$i];
                            $share_video_in_group->save();
                        }
                    }
                }
            }
            return redirect()->route('user.medias.capture-image')->with('status', 'Uploaded successfully');
        } else {
            if ($request->hasFile('file_name')) {

                $media_type = $request->input('media_type');
                if ($media_type == 'video') {
                    $folder = 'videos';
                }
                if ($media_type == 'audio') {
                    $folder = 'audios';
                }

                // $file_name = $request->file('file_name')->store($folder, ['disk' => 'my_files']);
                $file_name = $request->file('file_name')->store($folder, 's3');

                $media = new Media();
                $media->title = $request->input('title');
                $media->description = $request->input('description');
                $media->path = '/';
                $media->file_name = $file_name;
                $media->type = $media_type;
                $media->user_id = Auth::user()->id;
                $media->save();

                if ($media) {
                    $recipient = $request->input('recipient_id');
                    $group = $request->input('group_id');
                    if ($recipient != null) {
                        if (count($recipient) > 0) {
                            for ($i = 0; $i < count($recipient); $i++) {
                                $share_video = new ShareMedia();
                                $share_video->media_id = $media->id;
                                $share_video->recipient_id = $recipient[$i];
                                $share_video->save();
                            }
                        }
                    }
                    if ($group != null) {
                        if (count($group) > 0) {
                            for ($i = 0; $i < count($group); $i++) {
                                $share_video_in_group = new ShareMediaGroup();
                                $share_video_in_group->media_id = $media->id;
                                $share_video_in_group->group_id = $group[$i];
                                $share_video_in_group->save();
                            }
                        }
                    }
                }

                return  response()->json(['success' => ($media) ? 1 : 0, 'message' => ($media) ? 'Uploaded successfully.' : "Some thing went wrong. Try again !."]);
            }
        }
    }

    public function myMedia()
    {
        $title = "MY MEDIA";
        $id = Auth::user()->id;
        $all_media = Media::where('user_id', $id)->get(['*']);

        $user_recipents = userRecipients($id);
        $user_groups =  Group::where('user_id', $id)->get(['id', 'group_title']);

        if (!$all_media->isEmpty()) {
            foreach ($all_media as $key => $media) {
                $recipients = ShareMedia::where('media_id', $media->id)
                ->join('users', 'share_media.recipient_id', '=', 'users.id')
                ->get(['share_media.recipient_id', 'users.name', 'users.last_name']);

                $groups = ShareMediaGroup::where('media_id', $media->id)
                ->join('groups', 'share_media_groups.group_id', '=', 'groups.id')
                ->get(['share_media_groups.group_id', 'groups.group_title']);

                if (!$recipients->isEmpty()) {
                    $media->recipient_id = $recipients[0]->recipient_id;
                    $media->recipient_first_name = $recipients[0]->name;
                    $media->recipient_last_name = $recipients[0]->last_name;
                    $media->all_recipient = $recipients;
                }
                if ($recipients->isEmpty()) {
                    $media->recipient_id = 0;
                    $media->recipient_first_name = 'N/A';
                    $media->recipient_last_name = '';
                    $media->all_recipient = null;
                }
                if (!$groups->isEmpty()) {
                    $media->group_title = $groups[0]->group_title;
                    $media->all_group = $groups;
                }
                if ($groups->isEmpty()) {
                    $media->group_title = '';
                    $media->all_group = null;
                }
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.media.myMedia', compact(
            'title',
            'all_media',
            'user_recipents',
            'user_groups',
            'file_path'
        ));
    }

    public function sharedMediaRecipents()
    {
        $title = "SHARED MEDIA BY RECIPIENTS";
        return view('frontend.media.sharedMediaRecipents', compact('title'));
    }

    public function sharedMedia()
    {
        $title = "SHARED MEDIA";
        return view('frontend.media.sharedMediaSingleRecipent', compact('title'));
    }

    public function myMediaDetails()
    {
        $title = "MY MEDIA DETAILS";
        return view('frontend.media.myMediaDetails', compact('title'));
    }

    public function legacy()
    {
        $title = "LEGACY";
        return view('frontend.legacy.legacy', compact('title'));
    }

    public function successLegacy()
    {
        $title = "SUCCESS LEGACY";
        return view('frontend.legacy.successLegacy', compact('title'));
    }

    public function scheduleMedia()
    {
        $title = "SCHEDULED MEDIA";
        return view('frontend.schedule.scheduleMedia', compact('title'));
    }

    public function deliveryMedia()
    {
        $title = "DELIVERY";
        return view('frontend.schedule.delivery', compact('title'));
    }

    public function successSchedule()
    {
        $title = "SCHEDULED DELIVERY";
        return view('frontend.schedule.successSchedule', compact('title'));
    }
}
