<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
use App\Models\ScheduleMedia;
use App\Models\ShareMedia;
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
        $update_user = User::findOrFail($id);
        $update_user->name = $request->name;
        $update_user->last_name = $request->last_name;
        $update_user->email = $request->email;
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
                'name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
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
            ->join('users', 'user_recipients.recipient_id', '=', 'users.id')
            ->leftjoin('user_groups', 'user_recipients.recipient_id', '=', 'user_groups.recipient_id')
            ->get(['user_recipients.recipient_id', 'users.name', 'users.last_name', 'users.profile_image', 'user_groups.recipient_id as group_recipient_id', 'user_groups.group_id']);

        if (!$user_recipents->isEmpty()) {
            foreach ($user_recipents as $key => $recipient) {
                $contact =  UserContact::where(['user_contacts.contact_id' => $recipient->recipient_id, 'user_contacts.user_id' => $id])
                    ->leftjoin('contact_status', 'user_contacts.contact_status_id', '=', 'contact_status.id')
                    ->get(['user_contacts.contact_status_id', 'contact_status.contact_title']);

                if (!$contact->isEmpty()) {
                    $recipient->contact_title = $contact[0]->contact_title;
                } else {
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
            'user_contact'
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
        $check_email =  User::where('email', $request->email)->get(['id', 'email']);

        if ($check_email->isEmpty()) {
            $request->validate([
                'name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
            ]);

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
            $add_recipent->save();

            if ($add_recipent) {
                $add_user_recipent = new UserRecipient();
                $add_user_recipent->recipient_id =  $add_recipent->id;
                $add_user_recipent->user_id      =  Auth::user()->id;
                $add_user_recipent->save();
            }
            if ($request->contact_status_id != null) {
                $add_contact = new UserContact();
                $add_contact->contact_status_id =  $request->contact_status_id;
                $add_contact->contact_id   =  $add_recipent->id;
                $add_contact->user_id   =  Auth::user()->id;
                $add_contact->save();
            }
            if ($request->group_id != null) {
                $add_recipent_in_group = new UserGroup();
                $add_recipent_in_group->recipient_id =  $add_recipent->id;
                $add_recipent_in_group->group_id     =  $request->group_id;
                $add_recipent_in_group->user_id     =  Auth::user()->id;
                $add_recipent_in_group->save();
            }
        } else {
            $add_user_recipent = new UserRecipient();
            $add_user_recipent->recipient_id =  $check_email[0]->id;
            $add_user_recipent->user_id      =  Auth::user()->id;
            $add_user_recipent->save();

            if ($request->contact_status_id != null) {
                $add_contact = new UserContact();
                $add_contact->contact_status_id =  $request->contact_status_id;
                $add_contact->contact_id   =  $check_email[0]->id;
                $add_contact->user_id   =  Auth::user()->id;
                $add_contact->save();
            }
            if ($request->group_id != null) {
                $add_recipent_in_group = new UserGroup();
                $add_recipent_in_group->recipient_id =  $check_email[0]->id;
                $add_recipent_in_group->group_id     =  $request->group_id;
                $add_recipent_in_group->user_id     =  Auth::user()->id;
                $add_recipent_in_group->save();
            }
        }

        return redirect()->route('user.recipents');
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

        $recipient =  User::where('id', $recipient_id)
            ->first(['users.id as recipient_id', 'users.name', 'users.last_name', 'users.profile_image', 'users.email', 'users.phone_number']);

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

        $recipient =  User::where('users.id', $recipient_id)
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->join('state_province', 'users.state_province_id', '=', 'state_province.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->first(['users.id as recipient_id', 'users.name as first_name', 'users.last_name', 'users.profile_image', 'users.email', 'users.country_code', 'users.phone_number', 'users.address', 'users.address_2', 'users.zip_postal_code', 'users.country_id', 'users.state_province_id', 'users.city_id', 'countries.country_name', 'countries.postal_code_format', 'state_province.name', 'cities.city_name']);

        $provinces = StateProvince::where('country_id', $recipient->country_id)
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
        $recipient_id = $request->recipient_id;
        $contact_status_id = $request->contact_status_id;

        $request->validate([
            'name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
            'country_id' => ['required'],
            'state_province_id' => ['required'],
            'city_id' => ['required'],
        ]);

        $update_recipient = User::findOrFail($recipient_id);
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

        $update_recipient = User::findOrFail($recipient_id);
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
            $delete_legacy = UserContact::where(['user_contacts.contact_id'=>$recipient_id, 'user_contacts.user_id'=>$id])->delete();
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
        $delete_from_recipient = UserRecipient::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_contact = UserContact::where(['contact_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_group = UserGroup::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_legacy = Legacy::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_schedule_media = ScheduleMedia::where(['recipient_id' => $request->id, 'user_id' => $id])->delete();

        $delete_from_share_media = ShareMedia::where('recipient_id', $request->id)->delete();

        return redirect()->route('user.recipents')->withSuccess('Recipient was deleted successfully');
        // return redirect()->route('user.medias.my-media');
    }
}
