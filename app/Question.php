<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use App\Category;

class Question extends Model
{
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
