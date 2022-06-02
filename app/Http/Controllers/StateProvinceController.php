<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateProvince;
use App\Models\Country;

class StateProvinceController extends Controller
{
    public function getStateProvinces($id)
    {
        $state_provinces = StateProvince::where(['country_id'=>$id, 'status'=>1])->orderBy('name', 'asc')->get();
        return $state_provinces;
    }

    public function index() {
        $provinces = StateProvince::join('countries', 'state_province.country_id', '=', 'countries.id')
        ->get(['state_province.*', 'countries.country_name']);
        
        return view('admin.provinces.allProvinces', compact('provinces'));
    }

    public function addForm() {
        $countries =  Country::all();
        return view('admin.provinces.addProvinceForm', compact('countries'));
    }

    public function store(Request $request) {
        if(isset($request->state_province_id)) {
            $add_update_province = StateProvince::findOrFail($request->state_province_id);
        } else {
            $add_update_province = new StateProvince();
        }
        $add_update_province->name = $request->state_province_name;
        $add_update_province->status = $request->status;
        $add_update_province->country_id = $request->country_id;
        $add_update_province->save();
        if($add_update_province) {
            return redirect()->route('admin.provinces');
        }
    }

    public function show($id)
    {
        $province = StateProvince::where('state_province.id', $id)->join('countries', 'state_province.country_id', '=', 'countries.id')
        ->get(['state_province.*', 'countries.id as country_id', 'countries.country_name']);

        $countries =  Country::all();

        if($province) {
            return view('admin.provinces.editProvinceForm', compact('province', 'countries'));
        } else {
            return view('admin.provinces.editProvinceForm')->with('status', 'Something went wrong!');
        }
    }
}
