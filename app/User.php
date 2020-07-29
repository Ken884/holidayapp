<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'first_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'role','password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function holiday_applications()
    {
        return $this->hasMany('App\HolidayApplication', 'employee_id');
    }

    public function expense_applications()
    {
        return $this->hasMany('App\ExpenseApplication', 'employee_id');
    }

    public function paid_holidays()
    {
        return $this->hasMany('App\PaidHoliday');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function role()
    {
        return $this->belongsTo('App\Role')->withDefault();
    }

    public function getFullNameAttribute()
    {
        return $this->last_name.' '.$this->first_name;
    }

}
