<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserRecipient;
use App\Models\ShareLegacy;
use App\Models\LegacyDelivery;
use App\Models\LegacyDistribution;

class deliveryLegacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliverylegacy:cron';

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
        $base_url = url('https://www.beternal.life/');
        $legacy_distribution = LegacyDistribution::where('status', 0)->get(['user_id']);
        if (!$legacy_distribution->isEmpty()) {
            foreach ($legacy_distribution as $distribution) {
                $user_id = $distribution->user_id;
                $recipient_ids = array();
                $share_legacy = ShareLegacy::where('user_id', $user_id)->get();
                if (!$share_legacy->isEmpty()) {
                    foreach ($share_legacy as $legacy) {
                        if (!(in_array($legacy->recipient_id, $recipient_ids))) {
                            array_push($recipient_ids, $legacy->recipient_id);
                        }
                    }
                }
                if (count($recipient_ids) > 0) {
                    $check_legacy = LegacyDelivery::where('user_id', $user_id)->first();
                    if ($check_legacy == null) {
                        $user = User::where('id', $user_id)->first(['name', 'last_name']);
                        for ($i = 0; $i < count($recipient_ids); $i++) {
                            $recipient = UserRecipient::where('recipient_id', $recipient_ids[$i])->first(['name', 'last_name', 'email']);

                            $token = rand() . 'rwrdgvwqx' . rand() . time() . rand() . 'nkhiyoybj' . rand();

                            $legacy_delivery = new LegacyDelivery();
                            $legacy_delivery->token = $token;
                            $legacy_delivery->user_id = $user_id;
                            $legacy_delivery->recipient_id = $recipient_ids[$i];
                            $legacy_delivery->save();

                            if ($legacy_delivery) {
                                $user_name = strtoupper($user->name);
                                $user_last_name = strtoupper($user->last_name);
                                $recipient_name = strtoupper($recipient->name);
                                $recipient_last_name = strtoupper($recipient->last_name);
                                $email = $recipient->email;
                                $user_token = $legacy_delivery->token;
                                $legacy_url = $base_url . 'legacy-view/' . $user_token;
                                session()->put(['email' => $email, 'name' => $recipient_name]);
                                $data = array(
                                    'user_name' => $user_name,
                                    'user_last_name' => $user_last_name,
                                    'recipient_name' => $recipient_name,
                                    'recipient_last_name' => $recipient_last_name,
                                    'legacy_url' => $legacy_url
                                );

                                Mail::send('emails.legacyToRecipient', $data, function ($message) {
                                    $message->to(session()->get('email'), session()->get('name'))->subject('Legacy Notifications');
                                    $message->from('team@beternal.life', 'bETERNAL Team');
                                });
                            }
                        }
                    }
                }
            }
        }

        return 0;
    }
}
