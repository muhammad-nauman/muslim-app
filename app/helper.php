<?php

use Illuminate\Support\Facades\Storage;
use wapmorgan\MediaFile\MediaFile;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Str;

if(! function_exists('get_audio_duration')) {
    function get_audio_duration(string $path): string
    {
        if(Str::endsWith($path, 'wav')) {
            $audio = MediaFile::open($path)->getAudio();
            $duration = $audio->getLength();
        } else {
            $audio = new Mp3Info($path);
            $duration = $audio->duration;
        }

        $audioMins = floor($duration / 60);
        $audioSeconds = floor($duration % 60);

        $audioMins = $audioMins > 9 ? $audioMins : '0' . $audioMins;
        $audioSeconds = $audioSeconds > 9 ? $audioSeconds : '0' . $audioSeconds;

        return $audioMins . ':' . $audioSeconds;
    }
}

if(! function_exists('get_file_with_storage_driver_path')) {
    function get_storage_driver_path(string $path): string
    {
        return Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() .'/' . $path;
    }
}
