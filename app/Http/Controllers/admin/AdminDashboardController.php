<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Media;

class AdminDashboardController extends Controller
{
    public function index(){
        $total_users =  User::where('role_id', 2)->count();
        $free_users =  User::where(['role_id' => 2, 'plan_id' => 1])->count();
        $subscription_users =  User::where('role_id', 2)->whereNotIn('plan_id', [1])->count();
        $total_media =  Media::count();
        return view('admin.index', compact(
            'total_users',
            'free_users',
            'subscription_users',
            'total_media'
        ));
    }
    public function allUsers(){
        $data   =   [
            'users' =>  User::orderBy('id', 'DESC')->get(),
        ];
        return view('admin.users.index',$data);
    }
    public function allRoles(){
        $data   =   [
            'roles' =>  UserRole::all()
        ];
        return view('admin.roles.index',$data);
    }
}
