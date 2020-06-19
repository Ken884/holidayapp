<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidHoliday extends Model
{
    //
    protected $table = 'paid_holidays';

    public function user()
    {
        $this->belongsTo('App\User');
    }
}
