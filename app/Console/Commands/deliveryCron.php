<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ScheduleMedia;
use App\Models\ScheduleMediaRecipient;
use App\Models\ScheduleDelivery;

class deliveryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:cron';

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
        $set_time = $hours . ':' . $minutes;
        $base_url = url('https://www.beternal.life/');

        $schedule_media = ScheduleMedia::where(['date' => $set_date, 'status' => 0])->get('*');
        $for_schedule = array();
        if (!$schedule_media->isEmpty()) {
            foreach ($schedule_media as $key => $media) {
                $get_date_time = explode(' ', $media->date_time);
                $get_time = explode(':', $get_date_time[1]);
                if ($get_time[0] < $hours) {
                    array_push($for_schedule, $media);
                } else if ($get_time[0] == $hours && $get_time[1] <= $minutes) {
                    array_push($for_schedule, $media);
                }
            }
        }
        if (count($for_schedule) > 0) {
            for ($i = 0; $i < count($for_schedule); $i++) {
                $user = User::where('id',$for_schedule[$i]->user_id)->get(['name','last_name']);
                $for_schedule[$i]->user_details = $user;

                $media_recipients = ScheduleMediaRecipient::where(['schedule_media_id' => $for_schedule[$i]->id, 'user_recipients.user_id' => $for_schedule[$i]->user_id])
                    ->join('user_recipients', 'schedule_media_recipients.recipient_id', '=', 'user_recipients.recipient_id')
                    ->get(['name', 'last_name', 'email']);

                if (!$media_recipients->isEmpty()) {
                    $for_schedule[$i]->media_recipients = $media_recipients;
                } else {
                    $for_schedule[$i]->media_recipients = null;
                }
            }

            for ($j = 0; $j < count($for_schedule); $j++) {
                $token = rand() . 'fhhfvhf' . rand() . time() . rand() . 'hfvhfhvf' . rand();
                $schedule_delivery = new ScheduleDelivery();
                $schedule_delivery->token = $token;
                $schedule_delivery->schedule_media_id = $for_schedule[$j]->id;
                $schedule_delivery->save();

                $update_schedule_status = ScheduleMedia::findOrFail($for_schedule[$j]->id);
                $update_schedule_status->status = 1;
                $update_schedule_status->save();

                if ($for_schedule[$j]->media_recipients != null) {
                    $user_name = $for_schedule[$j]->user_details[0]->name;
                    $user_last_name = $for_schedule[$j]->user_details[0]->last_name;
                    for ($k = 0; $k < count($for_schedule[$j]->media_recipients); $k++) {
                        $email = $for_schedule[$j]->media_recipients[$k]->email;
                        $name = $for_schedule[$j]->media_recipients[$k]->name;
                        $last_name = $for_schedule[$j]->media_recipients[$k]->last_name;

                        session()->put(['email' => $email, 'name' => $name]);
                        $media_url = $base_url . 'media-url/' . $schedule_delivery->token;
                        $data = array(
                            'user_first_name' => $user_name,
                            'user_last_name' => $user_last_name,
                            'first_name' => $name,
                            'last_name' => $last_name,
                            'media_url' => $media_url
                        );

                        Mail::send('emails.deliveryMedia', $data, function ($message) {
                            $message->to(session()->get('email'), session()->get('name'))->subject('Media Notifications');
                            $message->from('team@beternal.life', 'bETERNAL Team');
                        });
                    }
                }
            }
        }

        return 0;
    }
}
