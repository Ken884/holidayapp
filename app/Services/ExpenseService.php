<?php

namespace App\Services;

use DB;
use App\ExpenseApplication;
use App\ExpenseStatement;
use App\ExpenseType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;

class ExpenseService
{

    public function saveExpense($params)
    {

        DB::transaction(function () use ($params) {
            
            //経費精算書テーブルの登録・更新
            
            $expenseapp = ExpenseApplication::findOrNew($params['expense_id']);
            $expenseapp->employee_id = Auth::id();
            $expenseapp->submit_datetime = Carbon::now();
            $expenseapp->remarks = $params['remarks'];
            $expenseapp->application_status_id = $expenseapp->application_status_id ?? 1;
            $expenseapp->save();
            
            
            //経費明細テーブルの登録・更新
            if (ExpenseStatement::where('expense_id', $expenseapp->id)->exists()) {
                ExpenseStatement::where('expense_id', $expenseapp->id)->delete();
            }

            $esparams = [
                'statement_number' => $params['statement_number'],
                'occurred_date' => $params['occurred_date'],
                'statement' => $params['statement'],
                'expense_type_id' => $params['expense_type_id'],
                'amount'=> $params['amount']
            ];

            $records = collect($esparams)->transpose();

            foreach ($records as $record) {
                $es = new ExpenseStatement;
                $es->expense_id = $expenseapp->id;
                $es->statement_number = $record['statement_number'];
                $es->occurred_date = $record['occurred_date'];
                $es->statement = $record['statement'];
                $es->expense_type_id = $record['expense_type_id'];
                $es->amount = $record['amount'];
                $es->save();
            }
            
            // DBに保存

        }); // トランザクションここまで
    }

    public function authorize($params)
    {
        //トランザクション開始
        DB::transaction(function() use($params) {
            $expenseapp = ExpenseApplication::find($params['expense_id']);
            $expenseapp->application_status_id = 2;
            $expenseapp->save();            
        });
        //トランザクションここまで
    }

    public function decline($params)
    {
        //
        DB::transaction(function() use($params) {
            $expenseapp = ExpenseApplication::find($params['expense_id']);
            $expenseapp->application_status_id = 3;
            $expenseapp->save();
        });
    }
}
