<?php

namespace App\Http\Controllers\ExpenseApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ExpenseApplication;
use App\Http\Requests\ExpenseApplicationPostReq;
use App\Services\ExpenseService;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class ExpenseApplicationController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }


    //ダッシュボードへ遷移
    public function index()
    {
        $expenseApplications = ExpenseApplication::where('employee_id', Auth::user()->id);

        return view('expense/expenseHome', compact('expenseApplications'));
    }

    //新規作成
    public function expense_create()
    {
        $expenseApplication = new ExpenseApplication;
        $mode = 'new';
        return view ('expense/expenseApplication', compact('expenseApplication', 'mode'));
    }

    /**
     * 申請データを｢経費精算書テーブル｣と｢経費明細テーブル｣に保存
     * @param ExpenseApplicationPostReq $req バリデーションを通過したリクエストの値
     */
    public function expense_store(ExpenseApplicationPostReq $req)
    {
        $params = $req->all();
        
        $this->expenseService->saveExpense($params);
        
        /*
         *メール送信機能
        $to = 'test.mailing.lara@gmail.com';
        Mail::to($to)->send(new ApplyNotification());
        */

        return redirect('expenseapplications');
    }

    /*
     *詳細画面に遷移 
     */
    public function expense_show(ExpenseApplication $expenseApplication)
    {
        $statements = $expenseApplication->expense_statements()->get();
        return view('expense/expenseDetail', compact('expenseApplication', 'statements'));
    }

    
    public function expense_edit(ExpenseApplication $expenseApplication)
    {
        $statements = $expenseApplication->expense_statements()->get();
        $mode = 'edit';
        return view('expense/expenseApplication', compact('expenseApplication', 'statements', 'mode'));
    }
    

}
