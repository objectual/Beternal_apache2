<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(){
        $countries =  Country::all();
        return view('admin.countries.allCountries', compact('countries'));
    }

    public function addForm() {
        return view('admin.countries.addCountryForm');
    }

    public function store(Request $request) {
        if(isset($request->country_id)) {
            $add_update_country = Country::findOrFail($request->country_id);
        } else {
            $add_update_country = new Country();
        }
        $add_update_country->country_name = $request->country_name;
        $add_update_country->status = $request->status;
        $add_update_country->save();
        if($add_update_country) {
            return redirect()->route('admin.countries');
        }
    }

    public function show($id)
    {
        $country = Country::findOrFail($id);
        if($country) {
            return view('admin.countries.editCountryForm', compact('country'));
        } else {
            return view('admin.countries.editCountryForm')->with('status', 'Something went wrong!');
        }
    }
}
