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

        $this->info('Initialised Migration');

        foreach($items as $item) {
            $element = json_decode($item['elements']);
            $fileName = replace_special_alphabets(str_replace('%20', ' ', basename($element->{'90eee517-9c10-4297-a0d8-72c84ae74d22'}->url)));
            $this->info('migrating: ' . $item['title']);
            WeeklyReminder::create([
                'title' => $item['title'],
                'category_id' => Category::inRandomOrder()->first()->id,
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'publishing_timestamp' => $item['publishing_timestamp'],
                'type' => 'audio',
                'status' => 1,
                'is_from_old_server' => 1,
                'content' => 'public/audios/reminders/' . $fileName,
                'author_name' => 'Muslim App Admin',
                'is_file_exist' => Storage::exists('public/audios/reminders/' . $fileName) ? 1 : 0,
            ]);
        }
        $this->info('Migration Completed');
    }
}
