<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\PushNotification;

class usersStatusEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userstatus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_date = getdate(date("U"));
        $minutes = "$current_date[minutes]";
        $hours = "$current_date[hours]";
        $month = "$current_date[mon]";
        $date = "$current_date[mday]";
        $year = "$current_date[year]";
        $set_date = $year . '-' . $month . '-' . $date;
        $set_time = $hours . ':' . $minutes . ':' . 0 . 0;
        $date_time = $set_date . ' ' . $set_time;
        $base_url = url('https://www.beternal.life/');

        $first_email_users = LoginHistory::where(['login_history.status' => 0, 'push_notification' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'notification_date', 'user_first_email', 'name', 'email']);

        $second_email_users = LoginHistory::where(['login_history.status' => 0, 'user_first_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'first_email_date', 'user_second_email', 'name', 'email']);

        if (!$first_email_users->isEmpty()) {
            foreach ($first_email_users as $key => $user) {
                if ($user->user_first_email == 0) {
                    $date1 = $user->notification_date;
                    $date2 = $date_time;
                    $timestamp1 = strtotime($date1);
                    $timestamp2 = strtotime($date2);
                    $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                    $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                    if ($hours_diff > 24) {
                        $notification = new PushNotification();
                        $notification->type = 'first email';
                        $notification->token = $token;
                        $notification->user_id = $user->user_id;
                        $notification->save();

                        $update = LoginHistory::findOrFail($user->id);
                        $update->user_first_email = 1;
                        $update->first_email_date = $date_time;
                        $update->save();

                        $user_name = strtoupper($user->name);
                        session()->put(['email' => $user->email, 'name' => $user_name]);
                        $status_url = $base_url . 'email-status/first-email/' . $token;
                        $data = array(
                            'first_name' => $user_name,
                            'status_url' => $status_url
                        );

                        Mail::send('emails.userStatusEmail', $data, function ($message) {
                            $message->to(session()->get('email'), session()->get('name'))->subject('User Notifications');
                            $message->from('team@beternal.life', 'bETERNAL Team');
                        });
                    }
                }
            }
        }

        if (!$second_email_users->isEmpty()) {
            foreach ($second_email_users as $key => $user) {
                if ($user->user_second_email == 0) {
                    $date1 = $user->first_email_date;
                    $date2 = $date_time;
                    $timestamp1 = strtotime($date1);
                    $timestamp2 = strtotime($date2);
                    $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                    $token = rand() . 'qdewwqga' . rand() . time() . rand() . 'mkyikbkt' . rand();
                    if ($hours_diff > 24) {
                        $notification = new PushNotification();
                        $notification->type = 'second email';
                        $notification->token = $token;
                        $notification->user_id = $user->user_id;
                        $notification->save();

                        $update = LoginHistory::findOrFail($user->id);
                        $update->user_second_email = 1;
                        $update->second_email_date = $date_time;
                        $update->save();

                        $user_name = strtoupper($user->name);
                        session()->put(['email' => $user->email, 'name' => $user_name]);
                        $status_url = $base_url . 'email-status/second-email/' . $token;
                        $data = array(
                            'first_name' => $user_name,
                            'status_url' => $status_url
                        );

                        Mail::send('emails.userStatusEmail', $data, function ($message) {
                            $message->to(session()->get('email'), session()->get('name'))->subject('User Notifications');
                            $message->from('team@beternal.life', 'bETERNAL Team');
                        });
                    }
                }
            }
        }

        return 0;
    }
}
