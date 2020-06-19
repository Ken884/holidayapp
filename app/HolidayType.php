<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model
{
    //
    protected $table = 'holiday_types';

    public function holiday_application()
    {
        return $this->hasMany('App\HolidayApplication');
    }
}
