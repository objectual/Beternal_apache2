<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginHistory;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = "LOGIN";
        return view('auth.login', compact('title'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if(User::find(Auth::user()->id)->role->role_slug == 'admin'){
            return redirect()->route('admin.dashboard');
        }

        $id = Auth::user()->id;
        $mydate = getdate(date("U"));
        $minutes = "$mydate[minutes]";
        $hours = "$mydate[hours]";
        $date = "$mydate[mday]";
        $month = "$mydate[mon]";
        $year = "$mydate[year]";
        $media_time = $hours . ':' . $minutes;
        $set_date = $year . '-' . $month . '-' . $date;
        $date_time = $year . '-' . $month . '-' . $date . ' ' . $media_time;

        $check_user = LoginHistory::where('user_id', $id)->first();
        if ($check_user == null) {
            $login_history = new LoginHistory();
            $login_history->last_login = $date_time;
            $login_history->last_logout = $date_time;
            $login_history->status = 1;
            $login_history->user_id = $id;
            $login_history->save();
        } else {
            $login_history = LoginHistory::where('user_id', $id)->update([
                'last_login' => $date_time,
                'status' => 1,
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $id = Auth::user()->id;
        $mydate = getdate(date("U"));
        $minutes = "$mydate[minutes]";
        $hours = "$mydate[hours]";
        $date = "$mydate[mday]";
        $month = "$mydate[mon]";
        $year = "$mydate[year]";
        $media_time = $hours . ':' . $minutes;
        $set_date = $year . '-' . $month . '-' . $date;
        $date_time = $year . '-' . $month . '-' . $date . ' ' . $media_time;

        $check_user = LoginHistory::where('user_id', $id)->first();
        if ($check_user == null) {
            $login_history = new LoginHistory();
            $login_history->last_login = $date_time;
            $login_history->last_logout = $date_time;
            $login_history->status = 0;
            $login_history->user_id = $id;
            $login_history->save();
        } else {
            $login_history = LoginHistory::where('user_id', $id)->update([
                'last_logout' => $date_time,
                'status' => 0,
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }
}
