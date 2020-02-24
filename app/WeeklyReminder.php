<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class WeeklyReminder extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'content_url',
    ];


    public function getContentUrlAttribute()
    {
        if($this->type === 'audio') {
            return url(Storage::url($this->content));
        }
        return $this->content;
    }


    public function scopeExpired($query)
    {
        return $query->where('status', 2);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
