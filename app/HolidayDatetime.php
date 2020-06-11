<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HolidayDatetime extends Model
{
    protected $table = 'holiday_datetimes';

    protected $fillable = [
        'holiday_application_id',
        'holiday_date',
        'holiday_time_from',
        'holiday_time_to'
    ];

    public function holiday_application()
    {
        return $this->belongsTo('App\HolidayApplication');
    }
}
