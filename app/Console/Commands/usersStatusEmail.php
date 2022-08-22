<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserContact;
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

        $email_first_contact = LoginHistory::where(['login_history.status' => 0, 'user_second_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'second_email_date', 'first_contact_email', 'name']);

        $email_first_contact_2 = LoginHistory::where(['login_history.status' => 0, 'first_contact_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'first_contact_date', 'first_contact_email_2', 'name', 'email']);

        if (!$email_first_contact->isEmpty()) {
            foreach ($email_first_contact as $key => $user) {
                $first_contact = UserContact::where(['contact_status_id' => 1, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($first_contact != null) {
                    if ($user->first_contact_email == 0) {
                        $date1 = $user->second_email_date;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'first contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->first_contact_email = 1;
                            $update->first_contact_date = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($first_contact->name);
                            $contact_email = $first_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/first-contact/' . $token;
                            $distribution_url = $base_url . 'distribution/first-contact/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

        if (!$email_first_contact_2->isEmpty()) {
            foreach ($email_first_contact_2 as $key => $user) {
                $first_contact = UserContact::where(['contact_status_id' => 1, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($first_contact != null) {
                    if ($user->first_contact_email_2 == 0) {
                        $date1 = $user->first_contact_date;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'first contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->first_contact_email_2 = 1;
                            $update->first_contact_date_2 = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($first_contact->name);
                            $contact_email = $first_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/first-contact-2/' . $token;
                            $distribution_url = $base_url . 'distribution/first-contact-2/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

        $email_second_contact = LoginHistory::where(['login_history.status' => 0, 'first_contact_email_2' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'first_contact_date_2', 'second_contact_email', 'name']);

        $email_second_contact_2 = LoginHistory::where(['login_history.status' => 0, 'second_contact_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'second_contact_date', 'second_contact_email_2', 'name', 'email']);

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

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

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

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

        $email_third_contact = LoginHistory::where(['login_history.status' => 0, 'second_contact_email_2' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'second_contact_date_2', 'third_contact_email', 'name']);

        $email_third_contact_2 = LoginHistory::where(['login_history.status' => 0, 'third_contact_email' => 1])
        ->join('users', 'login_history.user_id', '=', 'users.id')
        ->get(['login_history.id', 'user_id', 'third_contact_date', 'third_contact_email_2', 'name', 'email']);

        if (!$email_third_contact->isEmpty()) {
            foreach ($email_third_contact as $key => $user) {
                $third_contact = UserContact::where(['contact_status_id' => 3, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($third_contact != null) {
                    if ($user->third_contact_email == 0) {
                        $date1 = $user->second_contact_date_2;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'third contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->third_contact_email = 1;
                            $update->third_contact_date = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($third_contact->name);
                            $contact_email = $third_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/third-contact/' . $token;
                            $distribution_url = $base_url . 'distribution/third-contact/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

        if (!$email_third_contact_2->isEmpty()) {
            foreach ($email_third_contact_2 as $key => $user) {
                $third_contact = UserContact::where(['contact_status_id' => 3, 'user_contacts.user_id' => $user->user_id])
                ->join('user_recipients', 'user_contacts.contact_id', '=', 'user_recipients.recipient_id')
                ->first(['name', 'email']);

                if ($third_contact != null) {
                    if ($user->third_contact_email_2 == 0) {
                        $date1 = $user->third_contact_date;
                        $date2 = $date_time;
                        $timestamp1 = strtotime($date1);
                        $timestamp2 = strtotime($date2);
                        $hours_diff = abs($timestamp2 - $timestamp1) / (60 * 60);
                        $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();
                        if ($hours_diff > 24) {
                            $notification = new PushNotification();
                            $notification->type = 'third contact';
                            $notification->token = $token;
                            $notification->user_id = $user->user_id;
                            $notification->save();

                            $update = LoginHistory::findOrFail($user->id);
                            $update->third_contact_email_2 = 1;
                            $update->third_contact_date_2 = $date_time;
                            $update->save();

                            $user_name = strtoupper($user->name);
                            $contact_name = strtoupper($third_contact->name);
                            $contact_email = $third_contact->email;
                            session()->put(['email' => $contact_email, 'name' => $contact_name]);
                            $status_url = $base_url . 'email-status/third-contact-2/' . $token;
                            $distribution_url = $base_url . 'distribution/third-contact-2/' . $token;
                            $data = array(
                                'user_name' => $user_name,
                                'contact_name' => $contact_name,
                                'status_url' => $status_url,
                                'distribution_url' => $distribution_url
                            );

                            Mail::send('emails.userContactEmail', $data, function ($message) {
                                $message->to(session()->get('email'), session()->get('name'))->subject('Contact Notifications');
                                $message->from('team@beternal.life', 'bETERNAL Team');
                            });
                        }
                    }
                }
            }
        }

        return 0;
    }
}
