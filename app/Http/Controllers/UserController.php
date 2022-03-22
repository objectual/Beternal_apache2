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
        $user_roles = UserRole::all();
        if ($user) {
            return view('admin.users.editUserForm', compact('user', 'user_roles'));
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
        $update_user->save();
        $user = userDetails($id);
        if ($update_user) {
            return view('admin.users.editUserForm', compact('user'))
                ->with('success', 'User has been successfully updated');
        } else {
            return view('admin.users.editUserForm', compact('user'))
                ->with('error', 'Something went wrong!');
        }
    }

    public function myAccountPage()
    {
        return view('frontend.user.index');
    }

    public function myAccountEdit()
    {
        $id = Auth::user()->id;
        $user = userDetails($id);
        $countries =  Country::all();

        $provinces = StateProvince::where('country_id', Auth::user()->country_id)
            ->get(['state_province.id', 'state_province.name']);

        $cities = City::where('state_province_id', Auth::user()->state_province_id)
            ->get(['cities.id', 'cities.city_name']);

        return view('frontend.user.edit', compact('user', 'countries', 'provinces', 'cities'));
    }

    public function myAccountUpdate(Request $request)
    {
        if ($request->password == null) {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                // 'email' => Rules::unique('users')->ignore(Auth::user()->id),
                'phone' => ['required', 'digits_between:5,14'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                'phone' => ['required', 'digits_between:5,14'],
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

        return redirect()->route('user.profile.update');
    }

    public function allRecipents()
    {
        $id = Auth::user()->id;
        $contact_status =  ContactStatus::all();
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        $user_contacts =  UserContact::where('user_id', $id)->get(['id', 'contact_id']);

        $user_recipents =  UserRecipient::where('user_id', $id)
        ->join('users', 'user_recipients.recipient_id', '=', 'users.id')
        ->leftjoin('user_groups', 'user_recipients.recipient_id', '=', 'user_groups.recipient_id')
        ->get(['user_recipients.recipient_id', 'users.name', 'users.last_name', 'users.profile_image', 'user_groups.recipient_id as group_recipient_id', 'user_groups.group_id']);
        
        return view('frontend.recipents.allRecipents', compact('contact_status', 'groups', 'user_recipents'));
    }

    public function addForm()
    {
        $id = Auth::user()->id;
        $countries =  Country::all();
        $contact_status =  ContactStatus::all();
        $contacts = UserContact::where('user_id', $id)->get(['contact_status_id']);
        $groups =  Group::where('user_id', $id)->get(['id', 'group_title']);
        
        return view('frontend.recipents.addRecipentForm', compact(
            'countries',
            'contact_status',
            'groups'
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
                'name' => ['required', 'string','min:3', 'max:255'],
                'last_name' => ['required', 'string','min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required','digits_between:5,14'],
                'address' => ['required', 'string','min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
            
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
            
            if($add_recipent) {
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
}
