<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use App\Quiz;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
