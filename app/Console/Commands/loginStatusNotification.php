<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\PushNotification;

class loginStatusNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loginstatus:notification';

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
        $url = 'https://fcm.googleapis.com/fcm/send';
        $current_date = getdate(date("U"));
        $minutes = "$current_date[minutes]";
        $hours = "$current_date[hours]";
        $month = "$current_date[mon]";
        $date = "$current_date[mday]";
        $year = "$current_date[year]";
        $set_date = $year . '-' . $month . '-' . $date;
        $set_time = $hours . ':' . $minutes . ':' . 0 . 0;
        $date_time = $set_date . ' ' . $set_time;

        $logout_users = LoginHistory::where(['login_history.status' => 0, 'users.role_id' => 2])
            ->join('users', 'login_history.user_id', '=', 'users.id')
            ->get(['login_history.id', 'last_logout', 'user_id', 'push_notification', 'users.name']);

        if (!$logout_users->isEmpty()) {
            foreach ($logout_users as $key => $user) {
                $date1 = $user->last_logout;
                $date2 = $date_time;
                $timestamp1 = strtotime($date1);
                $timestamp2 = strtotime($date2);
                $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                $token = rand() . 'fhhfvhf' . rand() . time() . rand() . 'hfvhfhvf' . rand();
                if ($user->push_notification == 0) {
                    if ($hours_diff > 24) {
                        $notification = new PushNotification();
                        $notification->type = 'not active';
                        $notification->token = $token;
                        $notification->user_id = $user->user_id;
                        $notification->save();

                        $update = LoginHistory::findOrFail($user->id);
                        $update->push_notification = 1;
                        $update->notification_date = $date_time;
                        $update->save();

                        $user_name = strtoupper($user->name);
                        $FcmToken = User::where('id', $user->user_id)->pluck('device_token')->all();

                        $serverKey = 'AAAAecwPLr8:APA91bHBoKxLzL-QMGhenZPxEjZUbNxETYeMtRCFhtLBQZzld_DqjQ9FHwcRmSzZIxzgznfepSiDdWQw3dQLsXWd-NJ6p_hHyEhpzK_570aMLBBM38LTAoJr9fs42o_DhvGMkfvbqajY'; // ADD SERVER KEY HERE PROVIDED BY FCM
                        $data = [
                            "registration_ids" => $FcmToken,
                            "notification" => [
                                "title" => 'bETERNAL Notification',
                                "body" => $user_name . ', are you ok?  We have not heard from you today?',
                                "click_action" => 'https://www.beternal.life/user-status/' . $token,
                            ]
                        ];
                        $encodedData = json_encode($data);

                        $headers = [
                            'Authorization:key=' . $serverKey,
                            'Content-Type: application/json',
                        ];

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                        // Disabling SSL Certificate support temporarly
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                        // Execute post
                        $result = curl_exec($ch);
                        if ($result === FALSE) {
                            die('Curl failed: ' . curl_error($ch));
                        }
                        // Close connection
                        curl_close($ch);
                        // FCM response
                    }
                }
            }
        }

        return 0;
    }
}
