<?php

namespace App\Console\Commands;

use App\WeeklyReminder;
use Illuminate\Console\Command;

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
        $weeklyReminders = WeeklyReminder::where('status', 0)
            ->where('publishing_timestamp', '<=', now())
            ->get();

        $weeklyReminders->map(function($weeklyReminder) {
            $weeklyReminder->status = 1;
            $weeklyReminder->published_at = now();
            $weeklyReminder->save();
        });

        $this->info('All publishable weekly reminders are published');
    }
}
