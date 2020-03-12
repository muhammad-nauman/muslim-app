<?php

namespace App\Console\Commands;

use App\Content;
use App\WeeklyReminder;
use Illuminate\Console\Command;

class UpdateFileNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:reminder_names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin can upload files with Swedish names, this command will
                             replace all swedish characters to their equivalent english
                             characters';

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
        $weeklyReminders = WeeklyReminder::get();

        $weeklyReminders->map(function ($reminder) {
            $this->info('Replacing special characters from Weekly Reminder ' . $reminder->title );
            $reminder->content = replace_special_alphabets($reminder->content);
            $reminder->save();
            return $reminder;
        });
        $contents = Content::where('type', 'audio')->get();

        $contents->map(function ($content) {
            $this->info('Replacing special characters from Content ' . $content->title);
            $content->content = replace_special_alphabets($content->content);
            $content->save();
            return $content;
        });

        $this->info('All the weekly reminders and Contents URL are successfully replaced with english characters.');
    }
}
