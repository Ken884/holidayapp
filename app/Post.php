<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
