<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseApplication extends Model
{
    //
    protected $table = 'expense_applications';

    protected $fillable = [
      'employee_id',
      'submit_datetime',
      'remarks',
      'application_status_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function expense_statements()
    {
        return $this->hasMany('App\ExpenseStatement', 'expense_id');
    }

    public function application_status()
    {
        return $this->belongsTo('App\ApplicationStatus');
    }
}
