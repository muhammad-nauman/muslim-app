<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = [];

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function weekly_reminders()
    {
        return $this->belongsToMany(WeeklyReminder::class);
    }

}
