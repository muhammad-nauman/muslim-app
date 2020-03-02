<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{
    protected $appends = [];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
