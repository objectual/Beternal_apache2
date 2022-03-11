<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Country;
use App\Models\StateProvince;
use App\Models\City;
use App\helpers;
use Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::join('user_roles', 'users.role_id', '=', 'user_roles.id')
        ->join('plans', 'users.plan_id', '=', 'plans.id')
        ->get(['users.*', 'user_roles.role_name', 'plans.title']);
        
        return view('admin.users.allUsers', compact('users'));
    }

    public function show($id)
    {
        $user = userDetails($id);
        if($user) {
            return view('admin.users.editUserForm', compact('user'));
        } else {
            return view('admin.users.editUserForm')->with('status', 'Something went wrong!');
        }
    }

    public function store(Request $request) {
        $id = $request->user_id;
        $update_user = User::findOrFail($id);
        $update_user->name = $request->name;
        $update_user->last_name = $request->last_name;
        $update_user->email = $request->email;
        $update_user->phone_number = $request->phone;
        $update_user->zip_postal_code = $request->zip_postal_code;
        $update_user->address = $request->address;
        $update_user->status = $request->status;
        $update_user->save();
        $user = userDetails($id);
        if($update_user) {
            return view('admin.users.editUserForm', compact('user'))
            ->with('success', 'User has been successfully updated');
        } else {
            return view('admin.users.editUserForm', compact('user'))
            ->with('error', 'Something went wrong!');
        }
    }

    public function myAccountPage(){
        return view('frontend.user.index');
    }

    public function myAccountEdit(){
        $id = Auth::user()->id;
        $user = userDetails($id);
        $countries =  Country::all();

        $provinces = StateProvince::where('country_id', Auth::user()->country_id)
        ->get(['state_province.id', 'state_province.name']);

        $cities = City::where('state_province_id', Auth::user()->state_province_id)
        ->get(['cities.id', 'cities.city_name']);

        return view('frontend.user.edit', compact('user', 'countries', 'provinces', 'cities'));
    }

    public function myAccountUpdate(Request $request){
        if($request->password == null) {
            $request->validate([
                'name' => ['required', 'string','min:3', 'max:255'],
                'last_name' => ['required', 'string','min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore(Auth::user()->id)],
                // 'email' => Rules::unique('users')->ignore(Auth::user()->id),
                'phone' => ['required','digits_between:5,14'],
                'address' => ['required', 'string','min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
        }else{
            $request->validate([
                'name' => ['required', 'string','min:3', 'max:255'],
                'last_name' => ['required', 'string','min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore(Auth::user()->id)],
                'phone' => ['required','digits_between:5,14'],
                'address' => ['required', 'string','min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'password' => ['confirmed', Rules\Password::defaults()],
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
        }
        if(request()->file('image')){
            $image = request()->file('image');
            $image_new =time().$image->getClientOriginalName();
            $image->move('public/media/image/',$image_new);
            $image_new  =   '/public/media/image/'.$image_new;
        }else{
            $image_new  =   Auth::user()->profile_image;
        }
        if(empty($request->password)){

            $user = User::where('id',Auth::user()->id)->update([
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
        }else{
            $user = User::where('id',Auth::user()->id)->update([
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
}
