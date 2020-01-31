<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Content;

class Category extends Model
{
    protected $guarded = [];

    public function content()
    {
        return $this->hasMany(Content::class);
    }


}
