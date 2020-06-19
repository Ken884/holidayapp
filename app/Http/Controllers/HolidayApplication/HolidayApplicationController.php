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

class HolidayApplicationController extends Controller
{
    protected $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }
    /**
     * 申請画面の項目の表示、入力値の保存に関するコントローラ
     */

    /*
    *休暇届のダッシュボードページ。自身の登録した休暇届の一覧を取得
    */
    public function index()
    {
        $query = HolidayApplication::query();

        $holidayApplications = HolidayApplication::where('employee_id', Auth::user()->id);

        return view('holiday/holidayHome', compact('holidayApplications'));
    }

    /*
    *申請画面に祝日の配列を渡す
    */
    public function holiday_create(Request $req)
    {
        $yasumiArray = $this->holidayService->getYasumiArray();
        $yasumiArray = json_encode($yasumiArray);
        return view('holiday/holidayApplication', compact('yasumiArray'));
    }
    
    /*
    * 編集画面の土日祝日を除いた期間計算
    */
    public function duration(Request $req)
    {
        $params = $req->all();

        $fromArr = preg_split('/\(/', $params['holiday_date_from']);
        $params['holiday_date_from'] = $fromArr[0];

        $toArr = preg_split('/\(/', $params['holiday_date_to']);
        $params['holiday_date_to'] = $toArr[0];

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

}
