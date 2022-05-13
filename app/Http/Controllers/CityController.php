<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;
use App\Models\StateProvince;

class CityController extends Controller
{
    public function getCities($id)
    {
        $cities = City::where(['state_province_id'=>$id, 'status'=>1])->get();
        return $cities;
    }

    public function index() {
        $cities = City::join('state_province', 'cities.state_province_id', '=', 'state_province.id')
        ->join('countries', 'state_province.country_id', '=', 'countries.id')
        ->get(['cities.*', 'state_province.name', 'countries.country_name']);
        
        return view('admin.cities.allCities', compact('cities'));
    }

    public function addForm() {
        $countries =  Country::all();
        return view('admin.cities.addCityForm', compact('countries'));
    }

    public function store(Request $request) {
        if(isset($request->city_id)) {
            $add_update_city = City::findOrFail($request->city_id);
        } else {
            $add_update_city = new City();
        }
        $add_update_city->city_name = $request->city_name;
        $add_update_city->status = $request->status;
        $add_update_city->state_province_id = $request->state_province_id;
        $add_update_city->save();
        if($add_update_city) {
            return redirect()->route('admin.cities');
        }
    }

    public function show($id)
    {
        $city = City::where('cities.id', $id)->join('state_province', 'cities.state_province_id', '=', 'state_province.id')
        ->join('countries', 'state_province.country_id', '=', 'countries.id')
        ->get(['cities.*', 'state_province.id as state_province_id', 'state_province.name', 'countries.id as country_id', 'countries.country_name']);

        if($city) {
            $countries =  Country::all();
            $all_provinces = activeStateProvince();
            $provinces =  StateProvince::where('country_id', $city[0]->country_id)->get();
            return view('admin.cities.editCityForm', compact(
                'city', 'provinces', 'countries', 'all_provinces'
            ));
        } else {
            return view('admin.cities.editCityForm')->with('status', 'Something went wrong!');
        }
    }
}
