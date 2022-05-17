<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        if(count($countries) > 0)
        {
            $state_provinces = StateProvince::where(['country_id'=>$countries[0]->id, 'status'=>1])->get();
        }
        if(isset($state_provinces) && count($state_provinces) > 0)
        {
            $cities = City::where(['state_province_id'=>$state_provinces[0]->id, 'status'=>1])->get();
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
        $request->validate([
            'name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
            'last_name' => ['required', 'string', 'alpha', 'min:3', 'max:255'],
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
        if(request()->file('image')){
            // dd('is image');
            $image = request()->file('image');
            $image_new =time().$image->getClientOriginalName();
            $image->move('public/media/image/',$image_new);
            $image_new  =   '/public/media/image/'.$image_new;
        }else{
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

        event(new Registered($user));

        Auth::login($user);

        $details = [
            'title' => 'Mail from ObjectualSystemLimited.com',
            'body' => 'This is for testing email'
        ];
       
        \Mail::to($user->email)->send(new \App\Mail\MyMail($details));

        return redirect()->route('success-signup');
    }
}
