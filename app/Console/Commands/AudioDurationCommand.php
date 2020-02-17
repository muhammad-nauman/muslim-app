<?php

namespace App\Console\Commands;

use App\Content;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AudioDurationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add duration of the audio file in the database.';

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
        $contents = Content::withTrashed()->where('type', 'audio')->get();

        $contents->map(function($content) {
            try {
                $content->duration = get_audio_duration(get_storage_driver_path($content->content));
                $content->save();
            } catch(Exception $e) {
                $this->error($e->getMessage());
            }
        });

        $this->info('Audio file durations are added successfully.');
    }
}
