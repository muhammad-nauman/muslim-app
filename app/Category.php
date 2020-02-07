<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Content;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function content()
    {
        return $this->hasMany(Content::class);
    }


}
