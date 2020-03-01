<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'content_url',
    ];


    public function getContentUrlAttribute()
    {
        if($this->type === 'audio') {
            return url(Storage::url(preg_replace('/\s/', '%20', $this->content)));
        }
        return $this->content;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }
}
