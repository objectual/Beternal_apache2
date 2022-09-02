<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserContact;
use App\Models\LoginHistory;
use App\Models\PushNotification;

class secondContactEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secondcontact:email';

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

        $email_second_contact = LoginHistory::where(['login_history.status' => 0, 'first_contact_email_2' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'first_contact_date_2', 'second_contact_email', 'name']);

        if (!$email_second_contact->isEmpty()) {
            foreach ($email_second_contact as $key => $user) {
                $second_contact = UserContact::where(['contact_status_id' => 2, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($second_contact != null) {
                    if ($user->second_contact_email == 0) {
                        $date1 = $user->first_contact_date_2;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'second contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->second_contact_email = 1;
                            $update->second_contact_date = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($second_contact->name);
                            $contact_email = $second_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/second-contact/' . $token;
                            $distribution_url = $base_url . 'distribution/second-contact/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            // Mail::send('emails.userContactEmail', $data, function ($message) {
                            //     $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                            //     $message->from('team@beternal.life', 'bETERNAL Team');
                            // });
                        }
                    }
                }
            }
        }

        $email_second_contact_2 = LoginHistory::where(['login_history.status' => 0, 'second_contact_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'second_contact_date', 'second_contact_email_2', 'name', 'email']);

        if (!$email_second_contact_2->isEmpty()) {
            foreach ($email_second_contact_2 as $key => $user) {
                $second_contact = UserContact::where(['contact_status_id' => 2, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($second_contact != null) {
                    if ($user->second_contact_email_2 == 0) {
                        $date1 = $user->second_contact_date;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'second contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->second_contact_email_2 = 1;
                            $update->second_contact_date_2 = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($second_contact->name);
                            $contact_email = $second_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/second-contact-2/' . $token;
                            $distribution_url = $base_url . 'distribution/second-contact-2/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            // Mail::send('emails.userContactEmail', $data, function ($message) {
                            //     $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                            //     $message->from('team@beternal.life', 'bETERNAL Team');
                            // });
                        }
                    }
                }
            }
        }
        
        return 0;
    }
}
