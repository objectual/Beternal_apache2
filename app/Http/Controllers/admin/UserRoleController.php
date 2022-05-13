<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRole;

class UserRoleController extends Controller
{
    public function index(){
        $roles =  UserRole::all();
        return view('admin.roles.allRoles', compact('roles'));
    }

    public function addForm() {
        return view('admin.roles.addRoleForm');
    }

    public function store(Request $request) {
        if(isset($request->role_id)) {
            $add_update_role = UserRole::findOrFail($request->role_id);
        } else {
            $add_update_role = new UserRole();
        }
        $role_slug = strtolower($request->role_title);
        $add_update_role->role_name = $request->role_title;
        $add_update_role->role_slug = $role_slug;
        $add_update_role->description = $request->description;
        $add_update_role->status = $request->status;
        $add_update_role->save();
        if($add_update_role) {
            return redirect()->route('admin.roles');
        }
    }

    public function show($id)
    {
        $user_role = UserRole::findOrFail($id);
        if($user_role) {
            return view('admin.roles.editRoleForm', compact('user_role'));
        } else {
            return view('admin.roles.editRoleForm')->with('status', 'Something went wrong!');
        }
    }
}
