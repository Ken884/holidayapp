<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayApplication extends Model
{
    protected $table = 'holiday_applications';

    protected $fillable = [
        'employee_id',
        'submit_date',
        'holiday_class_common_id',
        'reason',
        'remarks',
        'appliication_status'
    ];
}
