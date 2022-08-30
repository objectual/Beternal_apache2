<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Country;
use App\Models\StateProvince;
use App\Models\City;
use App\Models\UserContact;
use App\Models\ContactStatus;
use App\Models\Group;
use App\Models\UserRecipient;
use App\Models\UserGroup;
use App\Models\UserRole;
use App\Models\Plan;
use App\Models\Legacy;
use App\Models\ShareLegacy;
use App\Models\ShareLegacyGroup;
use App\Models\Media;
use App\Models\ScheduleMedia;
use App\Models\ScheduleMediaRecipient;
use App\Models\ShareMedia;
use App\Models\ShareMediaGroup;
use App\Models\LoginHistory;
use App\Models\PushNotification;
use App\Models\LegacyDistribution;
use App\Models\LegacyDelivery;
use App\helpers;

class UserController extends Controller
{
    public function index()
    {
        $users = User::join('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->join('plans', 'users.plan_id', '=', 'plans.id')
            ->get(['users.*', 'user_roles.role_name', 'plans.title']);

        return view('admin.users.allUsers', compact('users'));
    }

    public function show($id)
    {
        $user = userDetails($id);
        $countries =  Country::all();
        $plans = Plan::where('status', 1)->get();
        $user_roles = UserRole::where('status', 1)->get();
        $postal_code_format = Country::where('id', $user[0]->country_id)
            ->get(['postal_code_format']);

        if (!$postal_code_format->isEmpty()) {
            $user[0]->zip_code_format = $postal_code_format[0]->postal_code_format;
        }
        if ($user) {
            $country_id = $user[0]->country_id;
            $state_province_id = $user[0]->state_province_id;
            $all_provinces = activeStateProvince();
            $all_cities = activeCities();
            $provinces = selectedStateProvince($country_id);
            $cities = selectedCities($state_province_id);
            return view('admin.users.editUserForm', compact(
                'user',
                'plans',
                'user_roles',
                'countries',
                'all_provinces',
                'all_cities',
                'provinces',
                'cities'
            ));
        } else {
            return view('admin.users.editUserForm')->with('status', 'Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        $id = $request->user_id;
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
            'country_id' => ['required'],
            'state_province_id' => ['required'],
            'city_id' => ['required'],
        ]);

        if ($request->city_id == 0) {
            $default_city = City::orderBy('id', 'desc')->first();
            $request->city_id = $default_city->id;
        }
        if ($request->postal_code_format == null) {
            $request->zip_postal_code = '00000';
        }

        $update_user = User::findOrFail($id);
        $update_user->name = $request->name;
        $update_user->last_name = $request->last_name;
        $update_user->email = $request->email;
        $update_user->country_code = $request->country_code;
        $update_user->phone_number = $request->phone;
        $update_user->zip_postal_code = $request->zip_postal_code;
        $update_user->address = $request->address;
        $update_user->status = $request->status;
        $update_user->role_id = $request->role_id;
        $update_user->plan_id = $request->plan_id;
        $update_user->country_id = $request->country_id;
        $update_user->state_province_id = $request->state_province_id;
        $update_user->city_id = $request->city_id;
        $update_user->save();
        if ($update_user) {
            return redirect('admin/users/show/' . $id)->with('success', 'User has been successfully updated');
        } else {
            return redirect('admin/users/show/' . $id)->with('error', 'Something went wrong!');
        }
    }

    public function myAccountPage()
    {
        $title = "MY ACCOUNT";
        return view('frontend.user.index', compact('title'));
    }

    public function myAccountEdit()
    {
        $title = "MY ACCOUNT EDIT";
        $id = Auth::user()->id;
        $user = userDetails($id);
        $countries =  Country::all();

        $postal_code_format = Country::where('id', Auth::user()->country_id)
            ->get(['postal_code_format']);

        if (!$postal_code_format->isEmpty()) {
            $user[0]->zip_code_format = $postal_code_format[0]->postal_code_format;
        }

        $provinces = StateProvince::where('country_id', Auth::user()->country_id)
            ->orderBy('name', 'asc')
            ->get(['state_province.id', 'state_province.name']);

        $cities = City::where('state_province_id', Auth::user()->state_province_id)
            ->get(['cities.id', 'cities.city_name']);

        return view('frontend.user.edit', compact(
            'title',
            'user',
            'countries',
            'provinces',
            'cities'
        ));
    }

    public function myAccountUpdate(Request $request)
    {
        if ($request->password == null) {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                // 'email' => Rules::unique('users')->ignore(Auth::user()->id),
                'phone' => ['required', 'string'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'password' => ['confirmed', Rules\Password::defaults()],
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
        }
        if ($request->city_id == 0) {
            $default_city = City::orderBy('id', 'desc')->first();
            $request->city_id = $default_city->id;
        }
        if (request()->file('image')) {
            $image = request()->file('image');
            $image_new = time() . $image->getClientOriginalName();
            $image->move('public/media/image/', $image_new);
            $image_new  =   '/public/media/image/' . $image_new;
        } else {
            $image_new  =   Auth::user()->profile_image;
        }
        if (empty($request->password)) {

            $user = User::where('id', Auth::user()->id)->update([
                'name'              =>  $request->name,
                'last_name'         =>  $request->last_name,
                'email'             =>  $request->email,
                'country_code'      =>  $request->country_code,
                'phone_number'      =>  $request->phone,
                'address'           =>  $request->address,
                'profile_image'     =>  $image_new,
                'country_id'        =>  $request->country_id,
                'state_province_id' =>  $request->state_province_id,
                'city_id'           =>  $request->city_id,
                'zip_postal_code'   =>  $request->zip_postal_code,
            ]);
        } else {
            $user = User::where('id', Auth::user()->id)->update([
                'name'              =>  $request->name,
                'last_name'         =>  $request->last_name,
                'email'             =>  $request->email,
                'country_code'      =>  $request->country_code,
                'phone_number'      =>  $request->phone,
                'address'           =>  $request->address,
                'profile_image'     =>  $image_new,
                'password'          =>  Hash::make($request->password),
                'country_id'        =>  $request->country_id,
                'state_province_id' =>  $request->state_province_id,
                'city_id'           =>  $request->city_id,
                'zip_postal_code'   =>  $request->zip_postal_code,
            ]);
        }

        // Auth::login($user);

        return redirect()->route('user.profile');
    }

    public function allRecipents()
    {
        $title = "RECIPIENTS";
        $id = Auth::user()->id;
        $contact_status =  ContactStatus::all();
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $user_contacts =  UserContact::where('user_id', $id)->get(['id', 'contact_id']);

        $user_recipents =  UserRecipient::where(['user_recipients.user_id' => $id, 'user_groups.user_id' => $id])
            ->leftjoin('user_groups', 'user_recipients.recipient_id', '=', 'user_groups.recipient_id')
            ->leftjoin('groups', 'user_groups.group_id', '=', 'groups.id')
            ->get(['user_recipients.recipient_id', 'user_recipients.name', 'user_recipients.last_name', 'user_recipients.profile_image', 'user_recipients.status', 'user_groups.recipient_id as group_recipient_id', 'user_groups.group_id', 'groups.group_title']);

        if (!$user_recipents->isEmpty()) {
            foreach ($user_recipents as $key => $recipient) {
                $contact =  UserContact::where(['user_contacts.contact_id' => $recipient->recipient_id, 'user_contacts.user_id' => $id])
                    ->leftjoin('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
                    ->get(['user_contacts.contact_status_id', 'contact_status.contact_title']);

                if (!$contact->isEmpty()) {
                    $recipient->contact_id = $contact[0]->contact_status_id;
                    $recipient->contact_title = $contact[0]->contact_title;
                } else {
                    $recipient->contact_id = 0;
                    $recipient->contact_title = '';
                }
            }
        }

        return view('frontend.recipents.allRecipents', compact(
            'title',
            'contact_status',
            'groups',
            'user_recipents'
        ));
    }

    public function addForm()
    {
        $title = "ADD RECIPIENT";
        $id = Auth::user()->id;
        $countries =  Country::all();
        $contact_status =  ContactStatus::all();
        $contacts = UserContact::where('user_id', $id)->get(['contact_status_id']);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $plan_details = Plan::where('id', Auth::user()->plan_id)->first(['recipient_limit']);
        $recipient_count =  UserRecipient::where('user_id', $id)->count();
        if ($groups->isEmpty()) {
            $defined_groups = array('Spouse or Partner', 'Family', 'Friend', 'None');
            for ($i = 0; $i < count($defined_groups); $i++) {
                $add_group = new Group();
                $add_group->group_title = $defined_groups[$i];
                $add_group->status = 1;
                $add_group->user_id = $id;
                $add_group->save();
            }
            $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        }
        $user_contact = array();
        if (!$contacts->isEmpty()) {
            foreach ($contacts as $contact) {
                array_push($user_contact, $contact->contact_status_id);
            }
        }

        return view('frontend.recipents.addRecipentForm', compact(
            'title',
            'countries',
            'contact_status',
            'groups',
            'user_contact',
            'plan_details',
            'recipient_count'
        ));
    }

    public function addGroup($group_title)
    {
        $id = Auth::user()->id;
        $add_group = new Group();
        $add_group->group_title = $group_title;
        $add_group->status = 1;
        $add_group->user_id = $id;
        $add_group->save();
        return $add_group;
    }

    public function addRecipent(Request $request)
    {
        $check_email =  User::where('email', $request->email)->get(['id', 'email', 'recipient_status']);

        if ($request->email == Auth::user()->email) {
            return redirect()->route('user.recipents.add-form')->with('message', 'Sorry you can not add recipient with your own email!');
        }
        if ($check_email->isEmpty()) {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
            ]);

            if ($request->city_id == 0) {
                $default_city = City::orderBy('id', 'desc')->first();
                $request->city_id = $default_city->id;
            }
            if ($request->postal_code_format == null) {
                $request->zip_postal_code = '00000';
            }
            if (request()->file('image')) {
                $image = request()->file('image');
                $image_new = time() . $image->getClientOriginalName();
                $image->move('public/media/image/', $image_new);
                $image_new  =   '/public/media/image/' . $image_new;
            } else {
                $image_new  =   '/public/media/image/default.png';
            }

            $password = '123456789';
            $add_recipent = new User();
            $add_recipent->name              =  $request->name;
            $add_recipent->last_name         =  $request->last_name;
            $add_recipent->email             =  $request->email;
            $add_recipent->country_code      =  $request->country_code;
            $add_recipent->phone_number      =  $request->phone;
            $add_recipent->address           =  $request->address;
            $add_recipent->address_2         =  $request->address_2;
            $add_recipent->profile_image     =  $image_new;
            $add_recipent->password          =  Hash::make($password);
            $add_recipent->role_id           =  2;
            $add_recipent->plan_id           =  1;
            $add_recipent->country_id        =  $request->country_id;
            $add_recipent->state_province_id =  $request->state_province_id;
            $add_recipent->city_id           =  $request->city_id;
            $add_recipent->zip_postal_code   =  $request->zip_postal_code;
            $add_recipent->recipient_status  =  0;
            $add_recipent->save();

            $contact_title = '';
            $token = rand() . 'fhhfvhf' . rand() . time() . rand() . 'hfvhfhvf' . rand();
            $for_user = 'emails.recipientMail';
            $for_recipient = 'emails.toRecipientMail';

            if ($add_recipent) {
                $add_user_recipent = new UserRecipient();
                $add_user_recipent->recipient_id      =  $add_recipent->id;
                $add_user_recipent->user_id           =  Auth::user()->id;
                $add_user_recipent->name              =  $request->name;
                $add_user_recipent->last_name         =  $request->last_name;
                $add_user_recipent->email             =  $request->email;
                $add_user_recipent->country_code      =  $request->country_code;
                $add_user_recipent->phone_number      =  $request->phone;
                $add_user_recipent->address           =  $request->address;
                $add_user_recipent->address_2         =  $request->address_2;
                $add_user_recipent->profile_image     =  $image_new;
                $add_user_recipent->country_id        =  $request->country_id;
                $add_user_recipent->state_province_id =  $request->state_province_id;
                $add_user_recipent->city_id           =  $request->city_id;
                $add_user_recipent->zip_postal_code   =  $request->zip_postal_code;
                $add_user_recipent->token             =  $token;
                $add_user_recipent->save();
            }
            if ($request->contact_status_id != null) {
                $add_contact = new UserContact();
                $add_contact->contact_status_id =  $request->contact_status_id;
                $add_contact->contact_id   =  $add_recipent->id;
                $add_contact->user_id   =  Auth::user()->id;
                $add_contact->save();

                $contact = ContactStatus::where('id', $add_contact->contact_status_id)->first();
                $contact_title = $contact->contact_title;
                $for_user = 'emails.contactMail';
                $for_recipient = '';
            }
            if ($request->group_id != null) {
                $add_recipent_in_group = new UserGroup();
                $add_recipent_in_group->recipient_id =  $add_recipent->id;
                $add_recipent_in_group->group_id     =  $request->group_id;
                $add_recipent_in_group->user_id     =  Auth::user()->id;
                $add_recipent_in_group->save();
            }

            session()->put(['email' => $add_recipent->email, 'name' => $add_recipent->name]);
            $base_url = url('');

            if ($for_recipient == '') {
                $deny_url = $base_url . '/deny-contact/' . $add_user_recipent->token;
                $confirmation_url = $base_url . '/confirmation-contact/' . $add_user_recipent->token;

                $data = array('first_name' => $add_recipent->name, 'last_name' => $add_recipent->last_name, 'contact_status' => $contact_title, 'deny_url' => $deny_url, 'confirm_url' => $confirmation_url);

                Mail::send($for_user, $data, function ($message) {
                    $message->to(Auth::user()->email, Auth::user()->name)->subject('Recipient Notifications');
                    $message->from('team@beternal.life', 'bETERNAL Team');
                });
            } else {
                $deny_url = $base_url . '/deny/' . $add_user_recipent->token;
                $confirmation_url = $base_url . '/confirmation/' . $add_user_recipent->token;

                $data = array('first_name' => $add_recipent->name, 'last_name' => $add_recipent->last_name, 'contact_status' => $contact_title, 'deny_url' => $deny_url, 'confirm_url' => $confirmation_url);

                Mail::send($for_user, $data, function ($message) {
                    $message->to(Auth::user()->email, Auth::user()->name)->subject('Recipient Notifications');
                    $message->from('team@beternal.life', 'bETERNAL Team');
                });
                Mail::send($for_recipient, $data, function ($message) {
                    $message->to(session()->get('email'), session()->get('name'))->subject('Recipient Notifications');
                    $message->from('team@beternal.life', 'bETERNAL Team');
                });
            }

            session()->forget('email');
            session()->forget('name');
        } else {
            $check_recipient = UserRecipient::where(['email' => $request->email, 'user_id' => Auth::user()->id])->get(['id', 'email']);
            if ($check_recipient->isEmpty()) {
                if ($request->city_id == 0) {
                    $default_city = City::orderBy('id', 'desc')->first();
                    $request->city_id = $default_city->id;
                }
                if ($request->postal_code_format == null) {
                    $request->zip_postal_code = '00000';
                }
                if (request()->file('image')) {
                    $image = request()->file('image');
                    $image_new = time() . $image->getClientOriginalName();
                    $image->move('public/media/image/', $image_new);
                    $image_new  =   '/public/media/image/' . $image_new;
                } else {
                    $image_new  =   '/public/media/image/default.png';
                }

                $contact_title = '';
                $token = rand() . 'fhhfvhf' . rand() . time() . rand() . 'hfvhfhvf' . rand();
                $for_user = 'emails.recipientMail';
                $for_recipient = 'emails.toRecipientMail';

                $add_user_recipent = new UserRecipient();
                $add_user_recipent->recipient_id      =  $check_email[0]->id;
                $add_user_recipent->user_id           =  Auth::user()->id;
                $add_user_recipent->name              =  $request->name;
                $add_user_recipent->last_name         =  $request->last_name;
                $add_user_recipent->email             =  $request->email;
                $add_user_recipent->country_code      =  $request->country_code;
                $add_user_recipent->phone_number      =  $request->phone;
                $add_user_recipent->address           =  $request->address;
                $add_user_recipent->address_2         =  $request->address_2;
                $add_user_recipent->profile_image     =  $image_new;
                $add_user_recipent->country_id        =  $request->country_id;
                $add_user_recipent->state_province_id =  $request->state_province_id;
                $add_user_recipent->city_id           =  $request->city_id;
                $add_user_recipent->zip_postal_code   =  $request->zip_postal_code;
                $add_user_recipent->token             =  $token;
                $add_user_recipent->save();

                if ($request->contact_status_id != null) {
                    $add_contact = new UserContact();
                    $add_contact->contact_status_id =  $request->contact_status_id;
                    $add_contact->contact_id   =  $check_email[0]->id;
                    $add_contact->user_id   =  Auth::user()->id;
                    $add_contact->save();

                    $contact = ContactStatus::where('id', $add_contact->contact_status_id)
                        ->first();

                    $contact_title = $contact->contact_title;
                    $for_user = 'emails.contactMail';
                    $for_recipient = '';
                }
                if ($request->group_id != null) {
                    $add_recipent_in_group = new UserGroup();
                    $add_recipent_in_group->recipient_id =  $check_email[0]->id;
                    $add_recipent_in_group->group_id     =  $request->group_id;
                    $add_recipent_in_group->user_id     =  Auth::user()->id;
                    $add_recipent_in_group->save();
                }

                session()->put(['email' => $add_user_recipent->email, 'name' => $add_user_recipent->name]);
                $base_url = url('');

                if ($for_recipient == '') {
                    $deny_url = $base_url . '/deny-contact/' . $add_user_recipent->token;
                    $confirmation_url = $base_url . '/confirmation-contact/' . $add_user_recipent->token;

                    $data = array('first_name' => $add_user_recipent->name, 'last_name' => $add_user_recipent->last_name, 'contact_status' => $contact_title, 'deny_url' => $deny_url, 'confirm_url' => $confirmation_url);

                    Mail::send($for_user, $data, function ($message) {
                        $message->to(Auth::user()->email, Auth::user()->name)->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });
                } else {
                    $deny_url = $base_url . '/deny/' . $add_user_recipent->token;
                    $confirmation_url = $base_url . '/confirmation/' . $add_user_recipent->token;

                    $data = array('first_name' => $add_user_recipent->name, 'last_name' => $add_user_recipent->last_name, 'contact_status' => $contact_title, 'deny_url' => $deny_url, 'confirm_url' => $confirmation_url);

                    Mail::send($for_user, $data, function ($message) {
                        $message->to(Auth::user()->email, Auth::user()->name)->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });
                    Mail::send($for_recipient, $data, function ($message) {
                        $message->to(session()->get('email'), session()->get('name'))->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });
                }

                session()->forget('email');
                session()->forget('name');
            } else {
                return redirect()->route('user.recipents.add-form')->with('message', 'You already have recipient with email "' . $request->email . '"');
            }
        }

        return redirect()->route('user.recipents');
    }

    public function recipientConfirmation(Request $request)
    {
        $title = "CONFIRMATION";
        $token = $request->token;
        $check_recipient = UserRecipient::where('token', $request->token)->first('status');
        if ($check_recipient) {
            if ($check_recipient->status == 0) {
                return view('frontend.confirmation', compact('title', 'token'));
            } else if ($check_recipient->status == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function updateConfirmation(Request $request)
    {
        $title = "CONFIRMATION SUCCESS";
        $check_recipient = UserRecipient::where('token', $request->token)->first(['recipient_id', 'user_id', 'status', 'name', 'last_name', 'email']);

        if ($check_recipient) {
            if ($check_recipient->status == 0) {
                $recipient = UserRecipient::where('token', $request->token)->update([
                    'status' => 1,
                ]);

                $check_contact = UserContact::where(['user_contacts.contact_id' => $check_recipient->recipient_id, 'user_contacts.user_id' => $check_recipient->user_id])
                    ->join('users', 'user_contacts.user_id', '=', 'users.id')
                    ->join('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
                    ->first(['users.name', 'users.last_name', 'users.email', 'contact_title']);

                $base_url = url('');
                $confirmation_url = $base_url . '/splash';

                if ($check_contact) {
                    session()->put(['email' => $check_recipient->email, 'name' => $check_recipient->name, 'user_email' => $check_contact->email, 'user_name' => $check_contact->name]);

                    $data = array('user_first_name' => $check_contact->name, 'user_last_name' => $check_contact->last_name, 'first_name' => $check_recipient->name, 'last_name' => $check_recipient->last_name, 'contact_title' => $check_contact->contact_title, 'confirm_url' => $confirmation_url);

                    Mail::send('emails.toUserConfirmationMail', $data, function ($message) {
                        $message->to(session()->get('user_email'), session()->get('user_name'))->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });
                    Mail::send('emails.toRecipientConfirmationMail', $data, function ($message) {
                        $message->to(session()->get('email'), session()->get('name'))->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });

                    session()->forget('email');
                    session()->forget('name');
                    session()->forget('user_email');
                    session()->forget('user_name');
                } else {
                    session()->put(['email' => $check_recipient->email, 'name' => $check_recipient->name]);

                    $data = array('first_name' => $check_recipient->name, 'last_name' => $check_recipient->last_name, 'confirm_url' => $confirmation_url);

                    Mail::send('emails.toRecipientConfirmationMail', $data, function ($message) {
                        $message->to(session()->get('email'), session()->get('name'))->subject('Recipient Notifications');
                        $message->from('team@beternal.life', 'bETERNAL Team');
                    });

                    session()->forget('email');
                    session()->forget('name');
                }

                $message = "We received your confirmation, thank you";
            } else if ($check_recipient->status == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function recipientDeny(Request $request)
    {
        $title = "DENY SUCCESS";
        $check_recipient = UserRecipient::where('token', $request->token)->first('status');

        if ($check_recipient) {
            if ($check_recipient->status == 0) {
                $recipient = UserRecipient::where('token', $request->token)->update([
                    'status' => 2,
                ]);
                $message = "Request has been denied!";
            } else if ($check_recipient->status == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function contactConfirmation(Request $request)
    {
        $title = "CONFIRMATION";
        $token = $request->token;
        $check_recipient = UserRecipient::where('token', $request->token)
            ->first('status_from_user');

        if ($check_recipient) {
            $status = $check_recipient->status_from_user;
            if ($status == 0) {
                return view('frontend.contactConfirmation', compact('title', 'token'));
            } else if ($status == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.contactConfirmation', compact('title', 'message'));
    }

    public function updateContactConfirmation(Request $request)
    {
        $title = "CONFIRMATION SUCCESS";
        $check_recipient = UserRecipient::where('token', $request->token)
            ->first(['recipient_id', 'user_id', 'status_from_user', 'name', 'last_name', 'email']);

        if ($check_recipient) {
            $recipient_id = $check_recipient->recipient_id;
            $user_id = $check_recipient->user_id;
            $status = $check_recipient->status_from_user;

            $user_contact = UserContact::where(['contact_id' => $recipient_id, 'user_id' => $user_id])
                ->join('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
                ->join('users', 'user_contacts.user_id', '=', 'users.id')
                ->first(['contact_title', 'name', 'last_name']);

            if ($status == 0) {
                $recipient = UserRecipient::where('token', $request->token)->update([
                    'status_from_user' => 1,
                ]);

                session()->put(['email' => $check_recipient->email, 'name' => $check_recipient->name]);

                $for_recipient = 'emails.toContactMail';
                $base_url = url('');
                $deny_url = $base_url . '/deny/' . $request->token;
                $confirmation_url = $base_url . '/confirmation/' . $request->token;

                $data = array('first_name' => $check_recipient->name, 'last_name' => $check_recipient->last_name, 'contact_status' => $user_contact->contact_title, 'deny_url' => $deny_url, 'confirm_url' => $confirmation_url, 'user_first_name' => $user_contact->name, 'user_last_name' => $user_contact->last_name);

                Mail::send($for_recipient, $data, function ($message) {
                    $message->to(session()->get('email'), session()->get('name'))->subject('Recipient Notifications');
                    $message->from('team@beternal.life', 'bETERNAL Team');
                });
                session()->forget('email');
                session()->forget('name');

                $message = "We received your confirmation, thank you";
            } else if ($status == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function contactDeny(Request $request)
    {
        $title = "DENY SUCCESS";
        $check_recipient = UserRecipient::where('token', $request->token)
            ->first('status_from_user');

        if ($check_recipient) {
            if ($check_recipient->status_from_user == 0) {
                $recipient = UserRecipient::where('token', $request->token)->update([
                    'status_from_user' => 2,
                ]);
                $message = "Request has been denied!";
            } else if ($check_recipient->status_from_user == 1) {
                $message = "You already confirmed";
            } else {
                $message = "You already denied";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function filterRecipent($contact_id)
    {
        $selected_contact = UserContact::where(['contact_status_id' => $contact_id, 'user_id' => Auth::user()->id])
            ->join('users', 'user_contacts.contact_id', '=', 'users.id')
            ->leftjoin('user_groups', 'users.id', '=', 'user_groups.recipient_id')
            ->get(['user_contacts.contact_id', 'users.name', 'users.last_name', 'users.profile_image', 'user_groups.recipient_id', 'user_groups.group_id']);
        return $selected_contact;
    }

    public function viewRecipent(Request $request)
    {
        $title = "VIEW RECIPIENT";
        $id = Auth::user()->id;
        $recipient_id = $request->id;

        $user_contacts =  UserContact::where(['contact_id' => $recipient_id, 'user_id' => $id])
            ->join('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
            ->first(['contact_status.id', 'contact_status.contact_title']);

        $user_group =  UserGroup::where(['recipient_id' => $recipient_id, 'user_groups.user_id' => $id])
            ->join('groups', 'user_groups.group_id', '=', 'groups.id')
            ->first(['groups.id', 'groups.group_title']);

        $recipient =  UserRecipient::where(['recipient_id' => $recipient_id, 'user_id' => $id])
            ->first(['recipient_id', 'name', 'last_name', 'profile_image', 'email', 'phone_number']);

        if ($user_contacts != null) {
            $recipient->contact_title = $user_contacts->contact_title;
        }
        if ($user_contacts == null) {
            $recipient->contact_title = 'N/A';
        }
        if ($user_group != null) {
            $recipient->group_title = $user_group->group_title;
        }
        if ($user_group == null) {
            $recipient->group_title = 'N/A';
        }

        return view('frontend.recipents.viewRecipent', compact('title', 'recipient'));
    }

    public function editRecipent(Request $request)
    {
        $title = "EDIT RECIPIENT";
        $id = Auth::user()->id;
        $recipient_id = $request->id;
        $countries =  Country::all();
        $contact_status =  ContactStatus::all();
        $contacts = UserContact::where('user_id', $id)->get(['contact_status_id']);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);

        $recipient =  UserRecipient::where(['user_recipients.recipient_id' => $recipient_id, 'user_id' => $id])
            ->join('countries', 'user_recipients.country_id', '=', 'countries.id')
            ->join('state_province', 'user_recipients.state_province_id', '=', 'state_province.id')
            ->join('cities', 'user_recipients.city_id', '=', 'cities.id')
            ->first(['user_recipients.id', 'user_recipients.recipient_id', 'user_recipients.name as first_name', 'user_recipients.last_name', 'user_recipients.profile_image', 'user_recipients.email', 'user_recipients.country_code', 'user_recipients.phone_number', 'user_recipients.address', 'user_recipients.address_2', 'user_recipients.zip_postal_code', 'user_recipients.country_id', 'user_recipients.state_province_id', 'user_recipients.city_id', 'countries.country_name', 'countries.postal_code_format', 'state_province.name', 'cities.city_name']);

        $provinces = StateProvince::where('country_id', $recipient->country_id)
            ->orderBy('name', 'asc')
            ->get(['state_province.id', 'state_province.name']);

        $cities = City::where('state_province_id', $recipient->state_province_id)
            ->get(['cities.id', 'cities.city_name']);

        $user_contacts =  UserContact::where(['contact_id' => $recipient_id, 'user_id' => $id])
            ->join('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
            ->first(['contact_status.id', 'contact_status.contact_title']);

        $user_group =  UserGroup::where(['recipient_id' => $recipient_id, 'user_groups.user_id' => $id])
            ->join('groups', 'user_groups.group_id', '=', 'groups.id')
            ->first(['groups.id', 'groups.group_title']);

        if ($user_contacts != null) {
            $recipient->contact_status_id = $user_contacts->id;
            $recipient->contact_title = $user_contacts->contact_title;
        }
        if ($user_contacts == null) {
            $recipient->contact_status_id = '';
            $recipient->contact_title = '';
        }
        if ($user_group != null) {
            $recipient->group_id = $user_group->id;
            $recipient->group_title = $user_group->group_title;
        }
        if ($user_group == null) {
            $recipient->group_id = '';
            $recipient->group_title = '';
        }

        $user_contact = array();
        if (!$contacts->isEmpty()) {
            foreach ($contacts as $contact) {
                array_push($user_contact, $contact->contact_status_id);
            }
        }

        return view('frontend.recipents.editRecipentForm', compact(
            'title',
            'countries',
            'contact_status',
            'groups',
            'recipient',
            'provinces',
            'cities',
            'user_contact'
        ));
    }

    public function updateRecipent(Request $request)
    {
        $id = Auth::user()->id;
        $user_recipient_id = $request->recipient_id;
        $contact_status_id = $request->contact_status_id;

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
            'country_id' => ['required'],
            'state_province_id' => ['required'],
            'city_id' => ['required'],
        ]);

        $update_recipient = UserRecipient::findOrFail($user_recipient_id);
        $recipient_id = $update_recipient->recipient_id;
        if ($request->city_id == 0) {
            $default_city = City::orderBy('id', 'desc')->first();
            $request->city_id = $default_city->id;
        }
        if ($request->postal_code_format == null) {
            $request->zip_postal_code = '00000';
        }
        if (request()->file('image')) {
            $image = request()->file('image');
            $image_new = time() . $image->getClientOriginalName();
            $image->move('public/media/image/', $image_new);
            $image_new  =   '/public/media/image/' . $image_new;
        } else {
            $image_new  =   $update_recipient->profile_image;
        }

        $update_recipient->name              =  $request->name;
        $update_recipient->last_name         =  $request->last_name;
        $update_recipient->email             =  $request->email;
        $update_recipient->country_code      =  $request->country_code;
        $update_recipient->phone_number      =  $request->phone;
        $update_recipient->address           =  $request->address;
        $update_recipient->address_2         =  $request->address_2;
        $update_recipient->profile_image     =  $image_new;
        $update_recipient->country_id        =  $request->country_id;
        $update_recipient->state_province_id =  $request->state_province_id;
        $update_recipient->city_id           =  $request->city_id;
        $update_recipient->zip_postal_code   =  $request->zip_postal_code;
        $update_recipient->save();

        if ($request->contact_status_id == null) {
            $delete_legacy = UserContact::where(['user_contacts.contact_id' => $recipient_id, 'user_contacts.user_id' => $id])->delete();
        }
        if ($request->contact_status_id != null) {
            $user_contact = UserContact::where(['contact_id' => $recipient_id, 'user_id' => $id])
                ->first(['id']);
            if ($user_contact == null) {
                $add_contact = new UserContact();
                $add_contact->contact_status_id = $request->contact_status_id;
                $add_contact->contact_id = $recipient_id;
                $add_contact->user_id = $id;
                $add_contact->save();
            } else {
                $update_contact = UserContact::findOrFail($user_contact->id);
                $update_contact->contact_status_id = $request->contact_status_id;
                $update_contact->save();
            }
        }
        if ($request->group_id != null) {
            $user_group = UserGroup::where(['recipient_id' => $recipient_id, 'user_groups.user_id' => $id])
                ->first(['id']);
            if ($user_group == null) {
                $add_in_group = new UserGroup();
                $add_in_group->recipient_id = $recipient_id;
                $add_in_group->group_id = $request->group_id;
                $add_in_group->user_id = $id;
                $add_in_group->save();
            } else {
                $update_in_group = UserGroup::findOrFail($user_group->id);
                $update_in_group->group_id = $request->group_id;
                $update_in_group->save();
            }
        }

        return redirect()->route('user.recipents');
    }

    public function deleteRecipent(Request $request)
    {
        $id = Auth::user()->id;
        $schedule_id = 0;
        $get_schedule_media = ScheduleMediaRecipient::where(['recipient_id' => $request->id, 'user_id' => $id])->first();

        if ($get_schedule_media != null) {
            $schedule_id = $get_schedule_media->schedule_media_id;
        }

        $delete_from_contact = UserContact::where(['contact_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_group = UserGroup::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_schedule_media = ScheduleMediaRecipient::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $check_schedule_media = ScheduleMediaRecipient::where('schedule_media_id', $schedule_id)->first();
        if ($check_schedule_media == null) {
            $delete_from_schedule = ScheduleMedia::where('id', $schedule_id)->delete();
        }

        $delete_from_share_media = ShareMedia::where('recipient_id', $request->id)->delete();

        $delete_from_recipient = UserRecipient::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        return redirect()->route('user.recipents')->withSuccess('Recipient was deleted successfully');
    }

    public function deleteUser(Request $request)
    {
        $id = Auth::user()->id;
        $user_legacy = Legacy::where('user_id', $request->id)->get(['id', 'file_name']);
        $user_media = Media::where('user_id', $request->id)->get(['id', 'file_name']);

        if (!$user_legacy->isEmpty()) {
            foreach ($user_legacy as $legacy) {
                Storage::disk('s3')->delete($legacy->file_name);
                $delete_from_share_legacy = ShareLegacy::where('legacy_id', $legacy->id)
                    ->delete();

                $delete_from_share_legacy_group = ShareLegacyGroup::where('legacy_id', $legacy->id)->delete();
            }
        }
        if (!$user_media->isEmpty()) {
            foreach ($user_media as $media) {
                Storage::disk('s3')->delete($media->file_name);
                $delete_from_share_media = ShareMedia::where('media_id', $media->id)->delete();

                $delete_from_share_media_group = ShareMediaGroup::where('media_id', $media->id)->delete();
            }
        }

        $delete_from_contact = UserContact::where('user_id', $request->id)->delete();
        $delete_from_group = UserGroup::where('user_id', $request->id)->delete();
        $delete_from_schedule_media_recipient = ScheduleMediaRecipient::where('user_id', $request->id)->delete();
        $delete_from_schedule_media = ScheduleMedia::where('user_id', $request->id)->delete();
        $delete_from_group = Group::where('user_id', $request->id)->delete();
        $delete_from_legacy = Legacy::where('user_id', $request->id)->delete();
        $delete_from_media = Media::where('user_id', $request->id)->delete();
        $delete_from_recipient = UserRecipient::where('user_id', $request->id)->delete();
        $delete_from_user = User::where('id', $request->id)->delete();

        return redirect()->route('admin.users')->with('message', 'Deleted successfully');
    }

    public function updateDeviceToken($token)
    {
        $id = Auth::user()->id;
        $store_token = DB::table('users')->where('id', $id)->update(['device_token' => $token]);
        return 'success';
    }

    public function userStatus(Request $request)
    {
        $title = "USER STATUS";
        $token = $request->token;
        $check_notification = PushNotification::where('token', $token)->first('status');
        if ($check_notification) {
            if ($check_notification->status == 0) {
                return view('frontend.userStatus', compact('title', 'token'));
            } else if ($check_notification->status == 1) {
                $message = "We already received your response";
            }
        } else {
            $message = "Not found any request!";
        }
        return view('frontend.userStatus', compact('title', 'message'));
    }

    public function updateUserStatus(Request $request)
    {
        $title = "USER STATUS SUCCESS";
        $notification = PushNotification::where('token', $request->token)
            ->first('user_id');

        if ($notification != null) {
            $update_notification = PushNotification::where('token', $request->token)
                ->update(['status' => 1]);

            if ($update_notification) {
                $update_status = LoginHistory::where('user_id', $notification->user_id)
                    ->update(['push_notification' => 2]);

                $message = "We have received your response, thank you";
            } else {
                $message = "Not found any request!";
            }
        } else {
            $message = "Not found any request!";
        }

        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function updateEmailStatus(Request $request)
    {
        $title = "USER STATUS SUCCESS";
        $current_date = getdate(date("U"));
        $minutes = "$current_date[minutes]";
        $hours = "$current_date[hours]";
        $month = "$current_date[mon]";
        $date = "$current_date[mday]";
        $year = "$current_date[year]";
        $set_date = $year . '-' . $month . '-' . $date;
        $set_time = $hours . ':' . $minutes . ':' . 0 . 0;
        $date_time = $set_date . ' ' . $set_time;

        $notification = PushNotification::where('token', $request->token)
            ->first(['status', 'user_id']);

        if ($notification != null) {
            if ($request->type == 'first-email') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['first_email_date']);

                $date1 = $chech_email->first_email_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['user_first_email' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'second-email') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['second_email_date']);

                $date1 = $chech_email->second_email_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['user_second_email' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'first-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['first_contact_date']);

                $date1 = $chech_email->first_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['first_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'first-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['first_contact_date_2']);

                $date1 = $chech_email->first_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['first_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'second-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['second_contact_date']);

                $date1 = $chech_email->second_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['second_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'second-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['second_contact_date_2']);

                $date1 = $chech_email->second_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['second_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'third-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['third_contact_date']);

                $date1 = $chech_email->third_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['third_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'third-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                    ->first(['third_contact_date_2']);

                $date1 = $chech_email->third_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                            ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['third_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            }
        } else {
            $message = "Not found any request!";
        }

        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function distributionStatus(Request $request)
    {
        $title = "USER STATUS SUCCESS";
        $current_date = getdate(date("U"));
        $minutes = "$current_date[minutes]";
        $hours = "$current_date[hours]";
        $month = "$current_date[mon]";
        $date = "$current_date[mday]";
        $year = "$current_date[year]";
        $set_date = $year . '-' . $month . '-' . $date;
        $set_time = $hours . ':' . $minutes . ':' . 0 . 0;
        $date_time = $set_date . ' ' . $set_time;
        $base_url = url('https://www.beternal.life/');

        $notification = PushNotification::where('token', $request->token)
        ->first(['status', 'user_id']);

        if ($notification != null) {
            if ($request->type == 'first-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['first_contact_date', 'name']);

                $user_contact = UserContact::where(['contact_status_id' => 1, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->first_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['first_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/first-contact/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'first-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['first_contact_date_2', 'name']);

                $user_contact = UserContact::where(['contact_status_id' => 1, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->first_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['first_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/first-contact-2/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'second-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['second_contact_date', 'name']);
                
                $user_contact = UserContact::where(['contact_status_id' => 2, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->second_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['second_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/second-contact/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'second-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['second_contact_date_2', 'name']);

                $user_contact = UserContact::where(['contact_status_id' => 2, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->second_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['second_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/second-contact-2/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'third-contact') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['third_contact_date', 'name']);

                $user_contact = UserContact::where(['contact_status_id' => 3, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->third_contact_date;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['third_contact_email' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/third-contact/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            } else if ($request->type == 'third-contact-2') {
                $chech_email = LoginHistory::where('user_id', $notification->user_id)
                ->join('users', 'login_history.user_id', '=', 'users.id')
                ->first(['third_contact_date_2', 'name']);

                $user_contact = UserContact::where(['contact_status_id' => 3, 'user_contacts.user_id' => $notification->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                $date1 = $chech_email->third_contact_date_2;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);

                if ($hours_diff <= 24) {
                    if ($notification->status == 0) {
                        $update_notification = PushNotification::where('token', $request->token)
                        ->update(['status' => 1]);

                        if ($update_notification) {
                            $update_status = LoginHistory::where('user_id', $notification->user_id)->update(['third_contact_email_2' => 2]);

                            $message = "We have received your response, thank you";
                            $token = $request->token;
                            $user_name = strtoupper($chech_email->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            $url = $base_url . 'legacy-confirmation/third-contact-2/' . $token;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'url' => $url
                            );

                            Mail::send('emails.legacyConfirmationEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "We have already received your response.";
                    }
                } else {
                    $message = "Not found any request!";
                }
            }
        } else {
            $message = "Not found any request!";
        }

        return view('frontend.confirmation', compact('title', 'message'));
    }

    public function legacyConfirmation(Request $request)
    {
        $title = "SUCCESS";
        $current_date = getdate(date("U"));
        $minutes = "$current_date[minutes]";
        $hours = "$current_date[hours]";
        $month = "$current_date[mon]";
        $date = "$current_date[mday]";
        $year = "$current_date[year]";
        $set_date = $year . '-' . $month . '-' . $date;
        $set_time = $hours . ':' . $minutes . ':' . 0 . 0;
        $date_time = $set_date . ' ' . $set_time;
        $base_url = url('https://www.beternal.life/');
        $first_contact = array('first-contact', 'first-contact-2');
        $second_contact = array('second-contact', 'second-contact-2');
        $third_contact = array('third-contact', 'third-contact-2');
        $message = 'something went wrong!';

        $notification = PushNotification::where('token', $request->token)->first(['user_id']);
        if ($notification != null) {
            $user_id = $notification->user_id;
            if (in_array($request->type, $first_contact)) {
                $user = User::where('id', $user_id)->first(['name']);
                $legacy = LegacyDistribution::where('user_id', $user_id)->first();
                if ($legacy == null) {
                    $user_contact = UserContact::where(['contact_status_id' => 1, 'user_contacts.user_id' => $user_id])
                    ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                    ->first(['user_contacts.id', 'name', 'email']);

                    if ($user_contact != null) {
                        $legacy_distribution = new LegacyDistribution();
                        $legacy_distribution->user_id = $user_id;
                        $legacy_distribution->authorized_id = $user_contact->id;
                        $legacy_distribution->save();

                        if ($legacy_distribution) {
                            $message = "Thank you";
                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name
                            );

                            Mail::send('emails.legacyDistributionSuccess', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "Not found any request!";
                    }
                } else {
                    $message = "Legacy has been already distributed, thank you.";
                }
            } else if (in_array($request->type, $second_contact)) {
                $user = User::where('id', $user_id)->first(['name']);
                $legacy = LegacyDistribution::where('user_id', $user_id)->first();
                if ($legacy == null) {
                    $user_contact = UserContact::where(['contact_status_id' => 2, 'user_contacts.user_id' => $user_id])
                    ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                    ->first(['user_contacts.id', 'name', 'email']);

                    if ($user_contact != null) {
                        $legacy_distribution = new LegacyDistribution();
                        $legacy_distribution->user_id = $user_id;
                        $legacy_distribution->authorized_id = $user_contact->id;
                        $legacy_distribution->save();

                        if ($legacy_distribution) {
                            $message = "Thank you";
                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name
                            );

                            Mail::send('emails.legacyDistributionSuccess', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "Not found any request!";
                    }
                } else {
                    $message = "Legacy has been already distributed, thank you.";
                }
            } else if (in_array($request->type, $third_contact)) {
                $user = User::where('id', $user_id)->first(['name']);
                $legacy = LegacyDistribution::where('user_id', $user_id)->first();
                if ($legacy == null) {
                    $user_contact = UserContact::where(['contact_status_id' => 3, 'user_contacts.user_id' => $user_id])
                    ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                    ->first(['user_contacts.id', 'name', 'email']);

                    if ($user_contact != null) {
                        $legacy_distribution = new LegacyDistribution();
                        $legacy_distribution->user_id = $user_id;
                        $legacy_distribution->authorized_id = $user_contact->id;
                        $legacy_distribution->save();

                        if ($legacy_distribution) {
                            $message = "Thank you";
                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($user_contact->name);
                            $email = $user_contact->email;
                            session()->put(['email' => $email, 'name' => $contact_name]);
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name
                            );

                            Mail::send('emails.legacyDistributionSuccess', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        } else {
                            $message = "Not found any request!";
                        }
                    } else {
                        $message = "Not found any request!";
                    }
                } else {
                    $message = "Legacy has been already distributed, thank you.";
                }
            }
        } else {
            $message = "Not found any request!";
        }

        return view('frontend.confirmation', compact('title', 'message'));
    }

}
