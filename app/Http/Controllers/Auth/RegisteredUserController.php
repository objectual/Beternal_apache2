<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\Country;
use App\Models\StateProvince;
use App\Models\City;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = "CREATE ACCOUNTT";
        $countries = Country::all();
        $state_provinces = [];
        $cities = [];
        if (count($countries) > 0) {
            $state_provinces = StateProvince::where(['country_id' => $countries[0]->id, 'status' => 1])->get();
        }
        if (isset($state_provinces) && count($state_provinces) > 0) {
            $cities = City::where(['state_province_id' => $state_provinces[0]->id, 'status' => 1])->get();
        }
        $countries = Country::all();
        return view('auth.register', compact(
            'title',
            'countries',
            'state_provinces',
            'cities'
        ));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $check_email =  User::where('email', $request->email)->get(['id', 'email', 'recipient_status']);

        if ($check_email->isEmpty()) {
            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'last_name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string'],
                'address' => ['required', 'string', 'min:5', 'max:255'],
                'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'country_id' => ['required'],
                'state_province_id' => ['required'],
                'city_id' => ['required'],
                'zip_postal_code' => ['required'],
            ]);
            if ($request->city_id == 0) {
                $default_city = City::orderBy('id', 'desc')->first();
                $request->city_id = $default_city->id;
            }
            if (request()->file('image')) {
                // dd('is image');
                $image = request()->file('image');
                $image_new = time() . $image->getClientOriginalName();
                $image->move('public/media/image/', $image_new);
                $image_new  =   '/public/media/image/' . $image_new;
            } else {
                // dd('not image');
                $image_new  =   '/public/media/image/default.png';
            }

            $user = User::create([
                'name'              =>  $request->name,
                'last_name'         =>  $request->last_name,
                'email'             =>  $request->email,
                'country_code'      =>  $request->country_code,
                'phone_number'      =>  $request->phone,
                'address'           =>  $request->address,
                'role_id'           =>  2,
                'profile_image'     =>  $image_new,
                'password'          =>  Hash::make($request->password),
                'plan_id'           =>  1,
                'country_id'        =>  $request->country_id,
                'state_province_id' =>  $request->state_province_id,
                'city_id'           =>  $request->city_id,
                'zip_postal_code'   =>  $request->zip_postal_code,
            ]);
        } else {
            if ($check_email[0]->recipient_status == 0) {
                $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:255'],
                    'last_name' => ['required', 'string', 'min:3', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($check_email[0]->id)],
                    'phone' => ['required', 'string'],
                    'address' => ['required', 'string', 'min:5', 'max:255'],
                    'image' => 'image|mimes:jpeg,png,jpg,svg,bmp',
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'country_id' => ['required'],
                    'state_province_id' => ['required'],
                    'city_id' => ['required'],
                    'zip_postal_code' => ['required'],
                ]);
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
                    $image_new  =   '/public/media/image/default.png';
                }

                $id = $check_email[0]->id;
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->country_code = $request->country_code;
                $user->phone_number = $request->phone;
                $user->address = $request->address;
                $user->profile_image = $image_new;
                $user->password = Hash::make($request->password);
                $user->country_id = $request->country_id;
                $user->state_province_id = $request->state_province_id;
                $user->city_id = $request->city_id;
                $user->zip_postal_code = $request->zip_postal_code;
                $user->recipient_status = 1;
                $user->save();
            } else {
                return redirect()->route('login')->with('message', 'You already have account! You can login');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        $details = [
            'title' => 'Mail from ObjectualSystemLimited.com',
            'body' => 'This is for testing email'
        ];

        Mail::to($user->email)->send(new \App\Mail\MyMail($details));

        return redirect()->route('success-signup');
    }
}
