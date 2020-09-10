<?php

namespace App\Console\Commands;

use App\Category;
use App\WeeklyReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateWeeklyReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will handle the migration of weekly reminders from old DB to the new server.';

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
        $items = getData();

        $this->info('Initialised Migrated Reminders Author Name Updation');

        foreach($items as $item) {
            $reminder = WeeklyReminder::where('title', $item['title'])->first();
            if(! is_null($reminder)) {
                $this->info('Updating: '. $item['title']);
                $reminder->update([
                    'author_name' => $item['created_by_alias']
                ]);
                $this->info('updated: '. json_encode($reminder->toArray()));
            }
        }
        $this->info('Completed Migrated Reminders Author Name Updation');
    }
}
