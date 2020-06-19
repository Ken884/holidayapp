<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    //
    protected $table = 'expense_types';

    public function expense_statemens()
    {
        return $this->hasMany('App\ExpenseStatement');
    }
}
