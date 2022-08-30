<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use App\Models\UserRecipient;
use App\Models\Group;
use App\Models\ShareMedia;
use App\Models\ShareMediaGroup;
use App\Models\Plan;
use App\Models\Legacy;
use App\Models\ScheduleMedia;
use App\Models\ScheduleMediaRecipient;
use App\Models\ScheduleDelivery;
use App\Models\ShareLegacy;
use App\Models\ShareLegacyGroup;
use App\Models\UserGroup;

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
        $user_recipents = userRecipients($id);
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

    public function uploadVideoFromMobile(Request $request)
    {
        $title = "UPLOAD VIDEO";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $plan_details = Plan::where('id', Auth::user()->plan_id)->get(['*']);
        $my_media = userAudioVideoCount($id);

        return view('frontend.media.uploadVideoFromMobile', compact(
            'title',
            'user_recipents',
            'groups',
            'plan_details',
            'my_media'
        ));
    }

    public function uploadMedia(Request $request)
    {
        date_default_timezone_set(session()->get('user_timezone'));
        if ($request->media_type == 'video') {
            // $this->validate($request, [
            //     'file_name' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
            // ]);
            $folder = 'videos';
            $route = 'user.media.capture-video';
        }
        if ($request->media_type == 'audio') {
            // $this->validate($request, [
            //     'file_name' => 'required|file|mimetypes:audio/mpeg,mpga,mp3,mp4,wav',
            // ]);
            $folder = 'audios';
            $route = 'user.media.capture-audio';
        }
        if ($request->media_type == 'photo') {
            $this->validate($request, [
                'file_name' => 'required|image|mimes:jpeg,png,jpg,svg,bmp',
            ]);
            $folder = 'photo';
            $route = 'user.media.capture-image';
        }

        if ($request->upload_type == "media") {
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
                if ($request->upload_type == "media") {
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
                }
                return redirect()->route('user.delivery')->with('message', 'Uploaded successfully');
            } else {
                return redirect()->route($route);
            }
        }
        if ($request->upload_type == "legacy") {
            $legacy = new Legacy();
            $legacy->title = $request->title;
            $legacy->description = $request->description;
            if ($request->hasFile('file_name')) {
                $path = $request->file('file_name')->store($folder, 's3');
                $legacy->file_name = $path;
            }
            $legacy->type = $request->media_type;
            $legacy->user_id = Auth::user()->id;
            $legacy->save();

            if ($legacy) {
                if (!(empty($request->recipient_id))) {
                    if (count($request->recipient_id) > 0) {
                        for ($i = 0; $i < count($request->recipient_id); $i++) {
                            $share_media = new ShareLegacy();
                            $share_media->legacy_id = $legacy->id;
                            $share_media->recipient_id = $request->recipient_id[$i];
                            $share_media->user_id = Auth::user()->id;
                            $share_media->save();
                        }
                    }
                }
                if (!(empty($request->group_id))) {
                    if (count($request->group_id) > 0) {
                        for ($i = 0; $i < count($request->group_id); $i++) {
                            $share_media_in_group = new ShareLegacyGroup();
                            $share_media_in_group->legacy_id = $legacy->id;
                            $share_media_in_group->group_id = $request->group_id[$i];
                            $share_media_in_group->save();
                        }
                    }
                }
                return redirect()->route('user.legacy')->with('message', 'Uploaded successfully');
            } else {
                return redirect()->route($route);
            }
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set(session()->get('user_timezone'));
        $media_type = $request->input('media_type');
        $upload_type = $request->input('upload_type');
        $base_url = url('');
        if ($media_type == 'photo') {
            $upload_type = $request->input('upload_type_2');
            $folder = 'photo/';
            $image = $request->input('image');  // your base64 encoded
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . 'png';
            $file_name = $folder . $imageName;
            // File::put(public_path('photo') . '/' . $imageName, base64_decode($image));
            Storage::disk('s3')->put(('photo') . '/' . $imageName, base64_decode($image));

            if ($upload_type == 'media') {
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
                return redirect()->route('user.delivery')->with('message', 'Uploaded successfully');
            }
            if ($upload_type == 'legacy') {
                $legacy = new Legacy();
                $legacy->title = $request->input('title_2');
                $legacy->description = $request->input('description_2');
                $legacy->file_name = $file_name;
                $legacy->type = $media_type;
                $legacy->user_id = Auth::user()->id;
                $legacy->save();

                $recipient = $request->input('recipient_id_2');
                $group = $request->input('group_id_2');
                if ($legacy) {
                    if ($recipient != null) {
                        if (count($recipient) > 0) {
                            for ($i = 0; $i < count($recipient); $i++) {
                                $share_media = new ShareLegacy();
                                $share_media->legacy_id = $legacy->id;
                                $share_media->recipient_id = $recipient[$i];
                                $share_media->user_id = Auth::user()->id;
                                $share_media->save();
                            }
                        }
                    }
                    if ($group != null) {
                        if (count($group) > 0) {
                            for ($i = 0; $i < count($group); $i++) {
                                $share_media_in_group = new ShareLegacyGroup();
                                $share_media_in_group->legacy_id = $legacy->id;
                                $share_media_in_group->group_id = $group[$i];
                                $share_media_in_group->save();
                            }
                        }
                    }
                }
                return redirect()->route('user.legacy')->with('message', 'Uploaded successfully');
            }
        } else {
            if ($request->hasFile('file_name')) {
                if ($media_type == 'video') {
                    $folder = 'videos';
                }
                if ($media_type == 'audio') {
                    $folder = 'audios';
                }

                $file_name = $request->file('file_name')->store($folder, 's3');
                $redirect_url = '';

                if ($upload_type == 'media') {
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

                    $redirect_url =  $base_url . '/media/my-media';
                    return  response()->json(['success' => ($media) ? 1 : 0, 'message' => ($media) ? 'Uploaded successfully.' : "Some thing went wrong. Try again !.", 'redirect_url' => ($media) ? $redirect_url : "Some thing went wrong. Try again !."]);
                }
                if ($upload_type == 'legacy') {
                    $legacy = new Legacy();
                    $legacy->title = $request->input('title');
                    $legacy->description = $request->input('description');
                    $legacy->file_name = $file_name;
                    $legacy->type = $media_type;
                    $legacy->user_id = Auth::user()->id;
                    $legacy->save();

                    $recipient = $request->input('recipient_id');
                    $group = $request->input('group_id');
                    if ($legacy) {
                        if ($recipient != null) {
                            if (count($recipient) > 0) {
                                for ($i = 0; $i < count($recipient); $i++) {
                                    $share_media = new ShareLegacy();
                                    $share_media->legacy_id = $legacy->id;
                                    $share_media->recipient_id = $recipient[$i];
                                    $share_media->user_id = Auth::user()->id;
                                    $share_media->save();
                                }
                            }
                        }
                        if ($group != null) {
                            if (count($group) > 0) {
                                for ($i = 0; $i < count($group); $i++) {
                                    $share_media_in_group = new ShareLegacyGroup();
                                    $share_media_in_group->legacy_id = $legacy->id;
                                    $share_media_in_group->group_id = $group[$i];
                                    $share_media_in_group->save();
                                }
                            }
                        }
                    }

                    $redirect_url = $base_url . '/legacy';
                    return  response()->json(['success' => ($legacy) ? 1 : 0, 'message' => ($legacy) ? 'Uploaded successfully.' : "Some thing went wrong. Try again !.", 'redirect_url' => ($legacy) ? $redirect_url : "Some thing went wrong. Try again !."]);
                }
            }
        }
    }

    public function myMedia()
    {
        $title = "MY MEDIA";
        $id = Auth::user()->id;
        $all_media = Media::where('user_id', $id)->get(['*']);
        $video_count =  Media::where(['user_id' => $id, 'type' => 'video'])->count();
        $audio_count =  Media::where(['user_id' => $id, 'type' => 'audio'])->count();
        $photo_count =  Media::where(['user_id' => $id, 'type' => 'photo'])->count();

        $user_recipents = userRecipients($id);
        $user_groups =  Group::where('user_id', $id)->get(['id', 'group_title']);

        if (!$all_media->isEmpty()) {
            foreach ($all_media as $key => $media) {
                $recipients = ShareMedia::where('media_id', $media->id)
                    ->join('user_recipients', 'share_media.recipient_id', '=', 'user_recipients.recipient_id')
                    ->get(['share_media.recipient_id', 'name', 'last_name']);

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
            'video_count',
            'audio_count',
            'photo_count',
            'user_recipents',
            'user_groups',
            'file_path'
        ));
    }

    public function sharedMedia()
    {
        $title = "SHARED MEDIA";
        $id = Auth::user()->id;
        $all_media = ShareMedia::where('share_media.recipient_id', $id)
            ->join('media', 'share_media.media_id', '=', 'media.id')
            ->join('user_recipients', 'media.user_id', '=', 'user_recipients.recipient_id')
            ->get([
                'share_media.recipient_id',
                'media.*', 'user_recipients.name as sender_first_name',
                'user_recipients.last_name as sender_last_name',
                'user_recipients.recipient_id as sender_id'
            ]);

        $user_recipents = userRecipients($id);
        $user_groups =  UserGroup::where('recipient_id', $id)
            ->leftjoin('groups', 'user_groups.group_id', '=', 'groups.id')->get(['groups.id', 'groups.group_title']);

        if (!$all_media->isEmpty()) {
            foreach ($all_media as $key => $media) {
                $groups = ShareMediaGroup::where('media_id', $media->id)
                    ->join('groups', 'share_media_groups.group_id', '=', 'groups.id')
                    ->get(['share_media_groups.group_id', 'groups.group_title']);

                if (!$groups->isEmpty()) {
                    $media->group_title = $groups[0]->group_title;
                }
                if ($groups->isEmpty()) {
                    $media->group_title = '';
                }
            }
        }
        if (!$user_groups->isEmpty()) {
            foreach ($user_groups as $key => $group) {
                $group_media = ShareMediaGroup::where('group_id', $group->id)
                    ->join('media', 'share_media_groups.media_id', '=', 'media.id')
                    ->join('users', 'media.user_id', '=', 'users.id')
                    ->get([
                        'media.*',
                        'users.name as sender_first_name',
                        'users.last_name as sender_last_name',
                        'users.id as sender_id'
                    ]);

                if (!$group_media->isEmpty()) {
                    $group->media = $group_media;
                }
                if ($group_media->isEmpty()) {
                    $group->media = null;
                }
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.media.sharedMediaRecipents', compact(
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
        return view('frontend.media.sharedMediaSingleRecipent', compact('title'));
    }

    public function myMediaDetails(Request $request)
    {
        $title = "MY MEDIA DETAILS";
        $get_media = Media::where('id', $request->id)->get(['*']);
        if (!$get_media->isEmpty()) {
            $get_legacy = Legacy::where('file_name', $get_media[0]->file_name)->get(['id']);
            $recipients = ShareMedia::where('media_id', $request->id)
                ->join('user_recipients', 'share_media.recipient_id', '=', 'user_recipients.recipient_id')
                ->get(['share_media.recipient_id', 'name', 'last_name', 'profile_image']);

            $groups = ShareMediaGroup::where('media_id', $request->id)
                ->join('groups', 'share_media_groups.group_id', '=', 'groups.id')
                ->get(['share_media_groups.group_id', 'groups.group_title']);

            if (!$get_legacy->isEmpty()) {
                $get_media[0]->is_legacy = $get_legacy;
            }
            if ($get_legacy->isEmpty()) {
                $get_media[0]->is_legacy = null;
            }
            if (!$recipients->isEmpty()) {
                $get_media[0]->all_recipient = $recipients;
            }
            if ($recipients->isEmpty()) {
                $get_media[0]->all_recipient = null;
            }
            if (!$groups->isEmpty()) {
                $get_media[0]->all_group = $groups;
            }
            if ($groups->isEmpty()) {
                $get_media[0]->all_group = null;
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.media.myMediaDetails', compact(
            'title',
            'get_media',
            'file_path'
        ));
    }

    public function myMediaDelete(Request $request)
    {
        $get_media = Media::where('id', $request->id)->get(['file_name']);
        if (!$get_media->isEmpty()) {
            $get_legacy = Legacy::where('file_name', $get_media[0]->file_name)->first();
            $delete_schedule_media = ScheduleMedia::where('media_id', $request->id)->delete();
            $delete_share_media = ShareMedia::where('media_id', $request->id)->delete();
            $delete_share_media_groups = ShareMediaGroup::where('media_id', $request->id)->delete();
            $delete_media = Media::where('id', $request->id)->delete();
            if ($get_legacy == null) {
                Storage::disk('s3')->delete($get_media[0]->file_name);
            }
            return redirect()->route('user.media.my-media')->withSuccess('File was deleted successfully');
        }
        return redirect()->route('user.media.my-media');
    }

    public function myMediaEdit(Request $request)
    {
        $title = "MY MEDIA EDIT";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $get_media = Media::where('id', $request->id)->get(['*']);
        if (!$get_media->isEmpty()) {
            $recipients = ShareMedia::where('media_id', $request->id)
                ->join('user_recipients', 'share_media.recipient_id', '=', 'user_recipients.recipient_id')
                ->get(['share_media.recipient_id', 'name', 'last_name', 'profile_image']);

            $user_groups = ShareMediaGroup::where('media_id', $request->id)
                ->join('groups', 'share_media_groups.group_id', '=', 'groups.id')
                ->get(['share_media_groups.group_id', 'groups.group_title']);

            if (!$recipients->isEmpty()) {
                $get_media[0]->all_recipient = $recipients;
            }
            if ($recipients->isEmpty()) {
                $get_media[0]->all_recipient = null;
            }
            if (!$user_groups->isEmpty()) {
                $get_media[0]->all_group = $user_groups;
            }
            if ($user_groups->isEmpty()) {
                $get_media[0]->all_group = null;
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.media.myMediaEdit', compact(
            'title',
            'user_recipents',
            'groups',
            'get_media',
            'file_path'
        ));
    }

    public function updateMedia(Request $request)
    {
        $media_id = $request->media_id;
        $update_media = Media::where('id', $media_id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($update_media) {
            $delete_share_media = ShareMedia::where('media_id', $media_id)->delete();
            $delete_share_group = ShareMediaGroup::where('media_id', $media_id)->delete();
            if (!(empty($request->recipient_id))) {
                if (count($request->recipient_id) > 0) {
                    for ($i = 0; $i < count($request->recipient_id); $i++) {
                        $share_media = new ShareMedia();
                        $share_media->media_id = $media_id;
                        $share_media->recipient_id = $request->recipient_id[$i];
                        $share_media->save();
                    }
                }
            }
            if (!(empty($request->group_id))) {
                if (count($request->group_id) > 0) {
                    for ($i = 0; $i < count($request->group_id); $i++) {
                        $share_media_in_group = new ShareMediaGroup();
                        $share_media_in_group->media_id = $media_id;
                        $share_media_in_group->group_id = $request->group_id[$i];
                        $share_media_in_group->save();
                    }
                }
            }
        }
        return redirect()->route('user.media.my-media')->with('message', 'Updated successfully');
    }

    public function legacy()
    {
        $title = "LEGACY";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $all_legacy = Legacy::where('user_id', $id)->get(['*']);
        $video_count =  Legacy::where(['user_id' => $id, 'type' => 'video'])->count();
        $audio_count =  Legacy::where(['user_id' => $id, 'type' => 'audio'])->count();
        $photo_count =  Legacy::where(['user_id' => $id, 'type' => 'photo'])->count();
        $user_groups =  Group::where('user_id', $id)->get(['id', 'group_title']);

        if (!$all_legacy->isEmpty()) {
            foreach ($all_legacy as $key => $legacy) {
                $recipients = ShareLegacy::where('legacy_id', $legacy->id)
                    ->join('user_recipients', 'share_legacy.recipient_id', '=', 'user_recipients.recipient_id')
                    ->get(['share_legacy.recipient_id', 'name', 'last_name']);

                $groups = ShareLegacyGroup::where('legacy_id', $legacy->id)
                    ->join('groups', 'share_legacy_groups.group_id', '=', 'groups.id')
                    ->get(['share_legacy_groups.group_id', 'groups.group_title']);

                if (!$recipients->isEmpty()) {
                    $legacy->recipient_id = $recipients[0]->recipient_id;
                    $legacy->recipient_first_name = $recipients[0]->name;
                    $legacy->recipient_last_name = $recipients[0]->last_name;
                    $legacy->all_recipient = $recipients;
                }
                if ($recipients->isEmpty()) {
                    $legacy->recipient_id = 0;
                    $legacy->recipient_first_name = 'N/A';
                    $legacy->recipient_last_name = '';
                    $legacy->all_recipient = null;
                }
                if (!$groups->isEmpty()) {
                    $legacy->group_title = $groups[0]->group_title;
                    $legacy->all_group = $groups;
                }
                if ($groups->isEmpty()) {
                    $legacy->group_title = '';
                    $legacy->all_group = null;
                }
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.legacy.legacy', compact(
            'title',
            'all_legacy',
            'video_count',
            'audio_count',
            'photo_count',
            'user_recipents',
            'user_groups',
            'file_path'
        ));
    }

    public function myLegacyDetails(Request $request)
    {
        $title = "LEGACY DETAILS";
        $get_legacy = Legacy::where('id', $request->id)->get(['*']);
        if (!$get_legacy->isEmpty()) {
            $recipients = ShareLegacy::where('legacy_id', $request->id)
                ->join('user_recipients', 'share_legacy.recipient_id', '=', 'user_recipients.recipient_id')
                ->get(['share_legacy.recipient_id', 'name', 'last_name', 'profile_image']);

            $groups = ShareLegacyGroup::where('legacy_id', $request->id)
                ->join('groups', 'share_legacy_groups.group_id', '=', 'groups.id')
                ->get(['share_legacy_groups.group_id', 'groups.group_title']);

            if (!$recipients->isEmpty()) {
                $get_legacy[0]->all_recipient = $recipients;
            }
            if ($recipients->isEmpty()) {
                $get_legacy[0]->all_recipient = null;
            }
            if (!$groups->isEmpty()) {
                $get_legacy[0]->all_group = $groups;
            }
            if ($groups->isEmpty()) {
                $get_legacy[0]->all_group = null;
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.legacy.legacyDetails', compact(
            'title',
            'get_legacy',
            'file_path'
        ));
    }

    public function legacyDelete(Request $request)
    {
        $get_legacy = Legacy::where('id', $request->id)->get(['file_name']);
        if (!$get_legacy->isEmpty()) {
            $get_media = Media::where('file_name', $get_legacy[0]->file_name)->first();
            $delete_share_legacy = ShareLegacy::where('legacy_id', $request->id)->delete();
            $delete_share_legacy_groups = ShareLegacyGroup::where('legacy_id', $request->id)->delete();
            $delete_legacy = Legacy::where('id', $request->id)->delete();
            if ($get_media == null) {
                Storage::disk('s3')->delete($get_legacy[0]->file_name);
            }
            return redirect()->route('user.legacy')->withSuccess('File was deleted successfully');
        }
        return redirect()->route('user.legacy');
    }

    public function legacyEdit(Request $request)
    {
        $title = "LEGACY EDIT";
        $id = Auth::user()->id;
        $user_recipents = userRecipients($id);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $get_legacy = Legacy::where('id', $request->id)->get(['*']);
        if (!$get_legacy->isEmpty()) {
            $recipients = ShareLegacy::where('legacy_id', $request->id)
                ->join('user_recipients', 'share_legacy.recipient_id', '=', 'user_recipients.recipient_id')
                ->get(['share_legacy.recipient_id', 'name', 'last_name', 'profile_image']);

            $user_groups = ShareLegacyGroup::where('legacy_id', $request->id)
                ->join('groups', 'share_legacy_groups.group_id', '=', 'groups.id')
                ->get(['share_legacy_groups.group_id', 'groups.group_title']);

            if (!$recipients->isEmpty()) {
                $get_legacy[0]->all_recipient = $recipients;
            }
            if ($recipients->isEmpty()) {
                $get_legacy[0]->all_recipient = null;
            }
            if (!$user_groups->isEmpty()) {
                $get_legacy[0]->all_group = $user_groups;
            }
            if ($user_groups->isEmpty()) {
                $get_legacy[0]->all_group = null;
            }
        }

        $full_path = Storage::disk('s3')->url('photo');
        $get_path = explode('photo', $full_path);
        $file_path = $get_path[0];

        return view('frontend.legacy.legacyEdit', compact(
            'title',
            'user_recipents',
            'groups',
            'get_legacy',
            'file_path'
        ));
    }

    public function legacyUpdate(Request $request)
    {
        $legacy_id = $request->legacy_id;
        $update_legacy = Legacy::where('id', $legacy_id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($update_legacy) {
            $delete_share_legacy = ShareLegacy::where('legacy_id', $legacy_id)->delete();
            $delete_share_group = ShareLegacyGroup::where('legacy_id', $legacy_id)->delete();
            if (!(empty($request->recipient_id))) {
                if (count($request->recipient_id) > 0) {
                    for ($i = 0; $i < count($request->recipient_id); $i++) {
                        $share_legacy = new ShareLegacy();
                        $share_legacy->legacy_id = $legacy_id;
                        $share_legacy->recipient_id = $request->recipient_id[$i];
                        $share_legacy->save();
                    }
                }
            }
            if (!(empty($request->group_id))) {
                if (count($request->group_id) > 0) {
                    for ($i = 0; $i < count($request->group_id); $i++) {
                        $share_legacy_in_group = new ShareLegacyGroup();
                        $share_legacy_in_group->legacy_id = $legacy_id;
                        $share_legacy_in_group->group_id = $request->group_id[$i];
                        $share_legacy_in_group->save();
                    }
                }
            }
        }
        return redirect()->route('user.legacy')->with('message', 'Updated successfully');
    }

    public function successLegacy()
    {
        $title = "SUCCESS LEGACY";
        return view('frontend.legacy.successLegacy', compact('title'));
    }

    public function legacyAdd(Request $request)
    {
        $media = Media::where('id', $request->id)->first(['*']);
        if ($media != null) {
            $share_media = ShareMedia::where('media_id', $media->id)->get();
            $share_media_group = ShareMediaGroup::where('media_id', $media->id)->get();

            $legacy = new Legacy();
            $legacy->title = $media->title;
            $legacy->description = $media->description;
            $legacy->file_name = $media->file_name;
            $legacy->type = $media->type;
            $legacy->user_id = Auth::user()->id;
            $legacy->save();

            if ($legacy) {
                if (!$share_media->isEmpty()) {
                    foreach ($share_media as $key => $share) {
                        $share_legacy = new ShareLegacy();
                        $share_legacy->legacy_id = $legacy->id;
                        $share_legacy->recipient_id = $share->recipient_id;
                        $share_legacy->save();
                    }
                }
                if (!$share_media_group->isEmpty()) {
                    foreach ($share_media_group as $key => $group) {
                        $share_legacy_group = new ShareLegacyGroup();
                        $share_legacy_group->legacy_id = $legacy->id;
                        $share_legacy_group->group_id = $group->group_id;
                        $share_legacy_group->save();
                    }
                }
                return redirect()->route('user.legacy')->with('message', 'Add in legacy successfully');
            } else {
                return redirect()->route('user.media.my-media');
            }
        } else {
            return redirect()->route('user.media.my-media');
        }
    }

    // public function detailsSchedule()
    // {
    //     $title = "DETAILS SCHEDULE";
    //     return view('frontend.schedule.scheduleDetails', compact('title'));
    // }

    public function scheduleMedia()
    {
        $title = "SCHEDULED MEDIA";
        return view('frontend.schedule.scheduleMedia', compact('title'));
    }

    public function scheduleTimezone($timezone, $state)
    {
        $set_timezone = $timezone . '/' . $state;
        date_default_timezone_set($set_timezone);
        $mydate = getdate(date("U"));
        $minutes = "$mydate[minutes]";
        $hours = "$mydate[hours]";
        $date = "$mydate[mday]";
        $month = "$mydate[mon]";
        $year = "$mydate[year]";

        $timezone_details = array(
            'message' => 'success', 'minutes' => $minutes, 'hours' => $hours, 'date' => $date, 'month' => $month, 'year' => $year
        );
        return $timezone_details;
    }

    public function deliveryMedia()
    {
        $title = "DELIVERY";
        $id = Auth::user()->id;
        $all_media = Media::where('user_id', $id)->get(['*']);
        $user_recipents = userRecipients($id);

        $schedule_media = ScheduleMedia::where('schedule_media.user_id', $id)
            ->join('media', 'schedule_media.media_id', '=', 'media.id')
            ->get(['schedule_media.id', 'schedule_media.date_time', 'schedule_media.description', 'schedule_media.message', 'schedule_media.media_id', 'schedule_media.date', 'schedule_media.date_time_for_user', 'media.file_name', 'media.type']);

        if (!$schedule_media->isEmpty()) {
            foreach ($schedule_media as $key => $schedule) {
                $recipients = ScheduleMediaRecipient::where('schedule_media_id', $schedule->id)
                    ->join('user_recipients', 'schedule_media_recipients.recipient_id', '=', 'user_recipients.recipient_id')
                    ->get(['name', 'last_name', 'profile_image']);

                if (!$recipients->isEmpty()) {
                    $schedule->all_recipient = $recipients;
                }
                if ($recipients->isEmpty()) {
                    $schedule->all_recipient = null;
                }

                $multiple_media = ScheduleMedia::where(['date' => $schedule->date, 'schedule_media.user_id' => $id])
                    ->join('media', 'schedule_media.media_id', '=', 'media.id')
                    ->get(['schedule_media.id', 'schedule_media.date_time', 'schedule_media.description', 'schedule_media.message', 'schedule_media.media_id', 'schedule_media.date', 'schedule_media.date_time_for_user', 'media.file_name', 'media.type']);

                if (!$multiple_media->isEmpty()) {
                    $schedule->multiple_media = $multiple_media;
                    foreach ($multiple_media as $key => $single_date) {
                        $media_recipients = ScheduleMediaRecipient::where('schedule_media_id', $single_date->id)
                            ->join('user_recipients', 'schedule_media_recipients.recipient_id', '=', 'user_recipients.recipient_id')
                            ->get(['name', 'last_name', 'profile_image']);

                        if (!$media_recipients->isEmpty()) {
                            $single_date->media_recipients = $media_recipients;
                        }
                        if ($media_recipients->isEmpty()) {
                            $single_date->media_recipients = null;
                        }
                    }
                } else {
                    $schedule->multiple_media = null;
                }
            }
        }

        if (!$all_media->isEmpty()) {
            foreach ($all_media as $key => $media) {
                $recipients = ShareMedia::where('media_id', $media->id)
                    ->join('user_recipients', 'share_media.recipient_id', '=', 'user_recipients.recipient_id')
                    ->get(['share_media.recipient_id', 'name', 'last_name']);

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

        return view('frontend.schedule.delivery', compact(
            'title',
            'all_media',
            'user_recipents',
            'file_path',
            'schedule_media'
        ));
    }

    public function scheduleDeliveryMedia(Request $request)
    {
        $before_user_timezone = getdate(date("U"));
        $hours = "$before_user_timezone[hours]";
        $date = $request->media_date;
        $month = $request->default_month;
        $year = $request->default_year;
        $time_format = $request->time_format;
        $pick_hours = $request->pick_hours;
        $pick_minutes = $request->pick_minutes;
        $day_night = $request->day_night;

        if ($time_format == 12) {
            if ($day_night == 'PM') {
                $pick_hours = $pick_hours + 12;
            }
        }

        $display_time = $pick_hours . ':' . $pick_minutes;
        if ($request->timezone_hours == null) {
            date_default_timezone_set(session()->get('user_timezone'));
            $user_timezone = getdate(date("U"));
            $user_hours = "$user_timezone[hours]";
            $hours_diff = $user_hours - $hours;
        } else {
            $hours_diff = $request->timezone_hours - $hours;
        }
        $pick_hours = $pick_hours - $hours_diff;
        $media_time = $pick_hours . ':' . $pick_minutes;
        $set_date = $year . '-' . $month . '-' . $date;
        $date_time = $set_date . ' ' . $media_time;
        $display_date_time = $set_date . ' ' . $display_time;

        if ($request->description == '') {
            $request->description = 'Not Found';
        }
        if ($request->message == '') {
            $request->message = 'Not Found';
        }
        if ($request->upload_type == "add_event") {
            $media = new ScheduleMedia();
            $media->date_time = $date_time;
            $media->description = $request->description;
            $media->message = $request->message;
            $media->media_id = $request->selected_file;
            $media->user_id = Auth::user()->id;
            $media->date = $set_date;
            $media->date_time_for_user = $display_date_time;
            $media->save();

            if ($media) {
                if (!(empty($request->recipient_id))) {
                    if (count($request->recipient_id) > 0) {
                        for ($i = 0; $i < count($request->recipient_id); $i++) {
                            $media_schedule = new ScheduleMediaRecipient();
                            $media_schedule->schedule_media_id = $media->id;
                            $media_schedule->recipient_id = $request->recipient_id[$i];
                            $media_schedule->user_id = Auth::user()->id;
                            $media_schedule->save();
                        }
                    }
                }
            }
            return redirect()->route('user.success-schedule')->with('message', $display_date_time);
        }
        if ($request->upload_type == "add_legacy") {
            $get_media = Media::where('id', $request->selected_file)->first('*');
            $legacy = new Legacy();
            $legacy->title = $get_media->title;
            $legacy->description = $request->description;
            $legacy->message = $request->message;
            $legacy->file_name = $get_media->file_name;
            $legacy->type = $get_media->type;
            $legacy->user_id = Auth::user()->id;
            $legacy->save();

            if ($legacy) {
                if (!(empty($request->recipient_id))) {
                    if (count($request->recipient_id) > 0) {
                        for ($i = 0; $i < count($request->recipient_id); $i++) {
                            $share_legacy = new ShareLegacy();
                            $share_legacy->legacy_id = $legacy->id;
                            $share_legacy->recipient_id = $request->recipient_id[$i];
                            $share_legacy->save();
                        }
                    }
                }
                return redirect()->route('user.legacy')->with('message', 'Uploaded successfully');
            } else {
                return redirect()->route('user.delivery');
            }
        }
    }

    public function successSchedule()
    {
        $title = "SCHEDULED DELIVERY";
        return view('frontend.schedule.successSchedule', compact('title'));
    }

    public function deleteSchedule(Request $request)
    {
        $id = $request->id;
        $with_recipient = ScheduleMediaRecipient::where('schedule_media_id', $id)->delete();
        $schedule_media = ScheduleMedia::where('id', $id)->delete();
        if ($with_recipient && $schedule_media) {
            return redirect()->route('user.delivery')->with('message', 'Deleted successfully');
        } else {
            return redirect()->route('user.delivery');
        }
    }

    function displayEventMedia(Request $request)
    {
        $title = "SHARED MEDIA";
        $check_token = ScheduleDelivery::where('token', $request->token)
            ->first('schedule_media_id');

        if ($check_token == null) {
            $message = "Not found any media!";
        } else {
            $schedule_media = ScheduleMedia::where('schedule_media.id', $check_token->schedule_media_id)
                ->join('media', 'schedule_media.media_id', '=', 'media.id')
                ->get(['schedule_media.description', 'message', 'file_name', 'type']);

            if (!$schedule_media->isEmpty()) {
                $full_path = Storage::disk('s3')->url('photo');
                $get_path = explode('photo', $full_path);
                $file_path = $get_path[0];

                return view('frontend.displayMedia', compact(
                    'title',
                    'file_path',
                    'schedule_media'
                ));
            } else {
                $message = "Not found any media!";
            }
        }
        return view('frontend.displayMedia', compact('title', 'message'));
    }
}
