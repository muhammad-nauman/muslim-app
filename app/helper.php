<?php

use Illuminate\Support\Facades\Storage;
use wapmorgan\Mp3Info\Mp3Info;

if(! function_exists('get_audio_duration')) {
    function get_audio_duration($path)
    {
        $audio = new Mp3Info($path);
        // dd(floor($audio->duration % 60));
        $audioMins = floor($audio->duration / 60);
        $audioSeconds = floor($audio->duration % 60);

        $audioMins = $audioMins > 9 ? $audioMins : '0' . $audioMins;
        $audioSeconds = $audioSeconds > 9 ? $audioSeconds : '0' . $audioSeconds;

        return $audioMins . ':' . $audioSeconds;
    }
}

if(! function_exists('get_file_with_storage_driver_path')) {
    function get_storage_driver_path($path)
    {
        return Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() .'/' . $path;
    }
}