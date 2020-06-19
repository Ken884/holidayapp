<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    //
    protected $table = 'departments';

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
