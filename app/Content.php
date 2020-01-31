<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Content extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
