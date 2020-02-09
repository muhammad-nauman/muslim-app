<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Content extends Model
{
    protected $guarded = [];

    protected $appends = [
        'content_url',
    ];


    public function getContentUrlAttribute()
    {
        if($this->type === 'audio') {
            return asset($this->content);
        }
        return $this->content;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
