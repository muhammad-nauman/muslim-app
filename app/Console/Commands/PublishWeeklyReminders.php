<?php

namespace App\Console\Commands;

use App\Device;
use App\WeeklyReminder;
use Illuminate\Console\Command;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PublishWeeklyReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will publish all the publishable weekly reminders';

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
     * @return mixed
     */
    public function handle()
    {
        info('Job Initialised');
        $weeklyReminders = WeeklyReminder::where('status', 0)
            ->where('publishing_timestamp', '<=', now()->timezone("Europe/Stockholm"))
            ->get();

        $weeklyReminders->map(function($weeklyReminder) {
            $weeklyReminder->status = 1;
            $weeklyReminder->published_at = now();
            $weeklyReminder->save();
            $this->notify($weeklyReminder);
        });

        $this->info('All publishable weekly reminders are published');
    }

    public function notify(WeeklyReminder $reminder)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*40);

        $notificationBuilder = new PayloadNotificationBuilder('Ny Påminnelse: ' . $reminder->title);
        $notificationBuilder->setBody('Talare: ' . $reminder->author_name)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $reminder]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = Device::where('fcm_id', '!=', '909039283928329##@')
            ->pluck('fcm_id')
            ->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        info('Notifications Sent.');
        info('Total Success Notifications: ' . $downstreamResponse->numberSuccess());
        info('Total Failed Notifications: ' . $downstreamResponse->numberFailure());
        info('Tokens to delete: ' . json_encode($downstreamResponse->tokensToDelete()));
        info('Tokens to Modify: ' . json_encode($downstreamResponse->tokensToModify()));
        info('Tokens to retry: ' . json_encode($downstreamResponse->tokensToRetry()));
        info('Tokens with errors: ' . json_encode($downstreamResponse->tokensWithError()));
        return;
//        dd($downstreamResponse->numberSuccess(),
//            $downstreamResponse->numberFailure(),
//            $downstreamResponse->numberModification(),
//            $downstreamResponse->tokensToDelete(),
//            $downstreamResponse->tokensToModify(),
//            $downstreamResponse->tokensToRetry(),
//            $downstreamResponse->tokensWithError());
    }
}
