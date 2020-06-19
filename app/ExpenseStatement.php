<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseStatement extends Model
{
    //
    protected $table = 'expense_statements';

    protected $fillable = [
        'expense_id',
        'statement_number',
        'occurred_date',
        'statement',
        'expense_type_id',
        'amount'
    ];

    public function expense_application()
    {
        return $this->belongsTo('App\ExpenseApplication');
    }

    public function expense_type()
    {
        return $this->belongsTo('App\ExpenseType');
    }
}
