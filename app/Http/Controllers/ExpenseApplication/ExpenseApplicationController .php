<?php

namespace App\Http\Controllers\ExpenseApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ExpenseApplication;
use App\ExpenseStatement;
use App\Http\Requests\ExpenseApplicationPostReq;
use App\Services\ExpenseService;
use App\User;
use Auth;
use App\Helpers\DateTimeHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseApplicationController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }


    //一覧画面
    public function index(Request $req)
    {
        $expenseApplications = $this->fetchUserList($req);
        $expenseApplications->transform(function($expenseApplication) {
            return [
                DateTimeHelper::parseDate($expenseApplication->submit_datetime),
                $expenseApplication->application_status->application_status_name,
                route('expense_show', $expenseApplication->id),
            ];
        });
        $expenseApplications = json_encode($expenseApplications);
        
        $apps = ExpenseApplication::where('employee_id', Auth::user()->id);
        $authorized = $apps->where('application_status_id', 2);
        $money = ExpenseStatement::whereIn('expense_id', $authorized->pluck('id'))->pluck('amount')->sum();
        $approved = $authorized->get()->count();
        $denied = $apps->where('application_status_id', 3)->get()->count();
        
        $info =[
            'money' => $money, 
            'approved' => $approved, 
            'denied' => $denied
        ];

        $listForAdmin = $this->fetchAdminList($req);
        $listForAdmin->transform(function($listApp) {
            return [
                DateTimeHelper::parseDate($listApp->submit_datetime),
                $listApp->user->full_name,
                $listApp->application_status->application_status_name,
                route('expense_show', $listApp->id),
            ];
        });
        $listForAdmin = json_encode($listForAdmin);

        return view('expense/expenseHome', compact('expenseApplications', 'listForAdmin', 'info'));
    }

    //ユーザー用・検索結果をAJAXで返す
    public function userSearch(Request $req)
    {
        $expenseApplications = $this->fetchUserList($req);
        $expenseApplications->transform(function($expenseApplication) {
            return [
                DateTimeHelper::parseDate($expenseApplication->submit_datetime),
                $expenseApplication->application_status->application_status_name,
                route('expense_show', $expenseApplication->id),
            ];
        });
        $expenseApplications = $expenseApplications->all();

        return  ['json' => $expenseApplications];
    }

    //管理者用・検索結果をAJAXで返す
    public function adminSearch(Request $req)
    {
        $listForAdmin = $this->fetchAdminList($req);
        $listForAdmin->transform(function($listApp) {
            return [
                DateTimeHelper::parseDate($listApp->submit_datetime),
                $listApp->user->full_name,
                $listApp->application_status->application_status_name,
                route('expense_show', $listApp->id),
            ];
        });
        $listForAdmin = $listForAdmin->all();

        return ['json' => $listForAdmin];
    }

    //ユーザー用一覧作成
    public function fetchUserList(Request $req)
    {
        $query = ExpenseApplication::where('employee_id', Auth::user()->id);

        $appStatus = $req->input('appStatus');
        $submitDate = $req->input('submitDate');

        //初期表示は全件
        $query->when(!($req->has('appStatus')) && !($req->has('submitDate')), function($query) {
            return $query;
        });

        //申請状況で検索
        $query->when($appStatus != null, function($query) use($appStatus){
            return $query->where('application_status_id', $appStatus);
        });

        //提出日で検索
        $query->when($submitDate != null, function($query) use($submitDate){
            return $query->whereDate('submit_datetime', $submitDate);
        });

        $expenseApplications = $query->orderByDesc('submit_datetime')->get();
        return $expenseApplications;
    }

    //管理者用一覧作成
    public function fetchAdminList(Request $req)
    {
        $members = User::where('role_id', '>' , Auth::user()->role_id)->where('department_id', '=', Auth::user()->department_id)->get();
        $query = ExpenseApplication::whereIn('employee_id', $members->pluck('id'));

        $appStatus = $req->input('appStatus');
        $submitDate = $req->input('submitDate');

        //初期表示は対象全件
        
        $query->when(!($req->has('appStatus')) && !($req->has('submitDate')), function($query) {
            return $query;
        });

        $query->when($appStatus != null, function($query) use($appStatus) {
            return $query->where('application_status_id', $appStatus);
        });

        //提出日で検索
        $query->when($submitDate != null, function($query) use($submitDate) {
            return $query->whereDate('submit_datetime', $submitDate);
        });

        $listForAdmin = $query->orderByDesc('submit_datetime')->get();
        return $listForAdmin;
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

    //詳細画面
    public function expense_show(ExpenseApplication $expenseApplication)
    {
        $statements = $expenseApplication->expense_statements()->get();
        return view('expense/expenseDetail', compact('expenseApplication', 'statements'));
    }

    //修正画面
    public function expense_edit(ExpenseApplication $expenseApplication)
    {
        $statements = $expenseApplication->expense_statements()->get();
        $mode = 'edit';
        return view('expense/expenseApplication', compact('expenseApplication', 'statements', 'mode'));
    }

    //承認・否認
    public function expense_authorize(Request $req)
    {
        $params = $req->all();
        if($params['authorization'] == 'authorized') {
            $this->expenseService->authorize($params);
        } else {
            $this->expenseService->decline($params);
        }

        return redirect('expenseapplications');
    }

}
