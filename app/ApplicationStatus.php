<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    //
    protected $table = 'application_statuses';

    protected $fillable = [
        'application_status_code',
        'application_status_name'
    ];

    public function holiday_applications()
    {
        return $this->hasMany('App\HolidayApplication');
    }

    public function expense_applications()
    {
        return $this->hasMany('App\ExpenseApplication');
    }
}
