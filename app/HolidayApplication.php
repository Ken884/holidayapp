<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayApplication extends Model
{
    protected $table = 'holiday_applications';

    protected $fillable = [
        'employee_id',
        'submit_datetime',
        'holiday_type_id',
        'reason',
        'remarks',
        'appliication_status_id',
        'denied_reason',
        'cancelled_reason'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id');
    }

    public function holiday_datetimes()
    {
        return $this->hasMany('App\HolidayDatetime');
    }

    public function holiday_type()
    {
        return $this->belongsTo('App\HolidayType');
    }

    public function application_status()
    {
        return $this->belongsTo('App\ApplicationStatus');
    }
}
