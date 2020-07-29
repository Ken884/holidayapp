<?php

namespace App\Http\Controllers\HolidayApplication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\HolidayApplication;
use App\HolidayDatetime;
use App\Http\Requests\HolidayApplicationPostReq;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Services\HolidayService;
use App\Http\Requests\HolidayDurationAjax;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplyNotification;
use App\Helpers\DateTimeHelper;

class HolidayApplicationController extends Controller
{
    protected $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }
    
    //一覧画面
    public function index(Request $req)
    {
        $holidayApplications = $this->fetchUserList($req)
        ->transform(function ($holidayApplication) {
            return [
                DateTimeHelper::parseDate($holidayApplication->submit_datetime),
                $holidayApplication->holiday_type->holiday_type_name,
                $holidayApplication->application_status->application_status_name,
                route('holiday_show', $holidayApplication->id),
            ];
        });
        $holidayApplications = json_encode($holidayApplications);

        $holidayapps = HolidayApplication::where('employee_id', Auth::user()->id);
        $authorized = $holidayapps->where('application_status_id', 2);
        
        $days = HolidayDatetime::whereIn('holiday_application_id', $authorized->pluck('id'))->count();
        $approved = $authorized->count();
        $denied = $holidayapps->where('application_status_id', 3)->count();
        $info = 
        [
            'days' => $days,
            'approved' => $approved,
            'denied' => $denied,
        ];


        $listForAdmin = $this->fetchAdminsList($req)
        ->transform(function ($listApp) {
            return [
                DateTimeHelper::parseDate($listApp->submit_datetime),
                $listApp->user->full_name,
                $listApp->holiday_type->holiday_type_name,
                $listApp->application_status->application_status_name,
                route('holiday_show', $listApp->id),
            ];
        });
        $listForAdmin = json_encode($listForAdmin);

        return view('holiday/holidayHome', compact('holidayApplications', 'info' , 'listForAdmin'));
    }

    //管理者用一覧絞り込み
    public function adminSearch(Request $req)
    {
        $listForAdmin = $this->fetchAdminsList($req)
        ->transform(function ($listApp) {
            return [
                DateTimeHelper::parseDate($listApp->submit_datetime),
                $listApp->user->last_name,
                $listApp->user->first_name,
                $listApp->holiday_type->holiday_type_name,
                $listApp->application_status->application_status_name,
                route('holiday_show', $listApp->id),
            ];
        });

        return ['json' => $listForAdmin];
    }

    //ユーザー用一覧絞り込み
    public function userSearch(Request $req)
    {
        $holidayApplications = $this->fetchUserList($req)
        ->transform(function ($holidayApplication) {
            return [
                DateTimeHelper::parseDate($holidayApplication->submit_datetime),
                $holidayApplication->holiday_type->holiday_type_name,
                $holidayApplication->application_status->application_status_name,
                route('holiday_show', $holidayApplication->id),
            ];
        });
        return ['json' => $holidayApplications];
    }

    public function fetchUserList(Request $req)
    {
        $query = HolidayApplication::where('employee_id', Auth::user()->id);

        $appStatus = $req['appStatus'];
        $submitDate = $req['submitDate'];
        //初期表示は全件
        $query->when(!($req->has('appStatus')) && !($req->has('submitDate')), function ($query) {
            return $query;
        });

        //申請状況で検索
        $query->when($appStatus != null, function ($query) use($appStatus) {
            return $query->where('application_status_id', $appStatus);
        });

        //提出日で検索
        $query->when($submitDate != null, function ($query) use($submitDate) {
            return $query->whereDate('submit_datetime', $submitDate);
        });

        $holidayApplications = $query->orderByDesc('submit_datetime')->get();
        return $holidayApplications;
    }

    public function fetchAdminsList(Request $req)
    {

        $members = User::where('role_id', '>', Auth::user()->role_id)->where('department_id', '=', Auth::user()->department_id);
        $query = HolidayApplication::whereIn('employee_id', $members->pluck('id'));

        $appStatus = $req['appStatus'];
        $submitDate = $req['submitDate'];

        //初期表示は全件
        $query->when(!($req->has('appStatus')) && !($req->has('submitDate')), function ($query) {
            return $query;
        });

        //申請状況で検索
        $query->when($appStatus != null, function ($query) use($appStatus) {
            return $query->where('application_status_id', $appStatus);
        });

        $query->when($submitDate != null, function ($query) use($submitDate) {
            return $query->whereDate('submit_datetime', $submitDate);
        });

        $listForAdmin = $query->orderByDesc('submit_datetime')->get();
        return $listForAdmin;
    }


    //申請画面に祝日の配列を渡す
    public function holiday_create(Request $req)
    {
        $holidayApplication = new HolidayApplication;
        $yasumiArray = $this->holidayService->getYasumiArray();
        $yasumiArray = json_encode($yasumiArray);
        $mode = 'new';
        return view('holiday/holidayApplication', compact('holidayApplication', 'yasumiArray', 'mode'));
    }
    
    /*
    * 編集画面の土日祝日を除いた期間計算
    */
    public function duration(Request $req)
    {
        $params = $req->all();

        $days = $this->holidayService->getDuration($params);
        return $days;
    }


    /**
     * 休暇届のデータを｢休暇届テーブル｣と｢休暇日時テーブル｣に保存
     * @param HolidayApplicationPostReq $req バリデーションを通過したリクエストの値
     */
    public function holiday_store(HolidayApplicationPostReq $req)
    {
        $params = $req->all();
        
        $this->holidayService->saveHoliday($params);

        /*
         *メール送信機能
        $to = 'test.mailing.lara@gmail.com';
        Mail::to($to)->send(new ApplyNotification());
        */

        return redirect('holidayapplications');
    }

    /*
     *詳細画面に遷移 
     */
    public function holiday_show(HolidayApplication $holidayApplication)
    {
        $datetime = $holidayApplication->holiday_datetimes()->get();
        return view('holiday/holidayDetail', compact('holidayApplication', 'datetime'));
    }

    //修正
    public function holiday_edit(HolidayApplication $holidayApplication)
    {
        //
        $datetime = $holidayApplication->holiday_datetimes()->get();
        $mode = 'edit';
        return view('holiday/holidayApplication', compact('holidayApplication', 'datetime' ,'mode'));
    }

    //承認・否認
    public function holiday_authorize(Request $req)
    {
        //
        $params = $req->all();
        if($params['authorization'] == 'authorized') {
            $this->holidayService->authorize($params);
        } else {
            $this->holidayService->decline($params);
        }

        return redirect('holidayapplications');
    }

}
