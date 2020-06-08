<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayClass;
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

    /**
    */
    public function index()
    {
        return view('holidayHome');
    }

    public function holiday_create(Request $req)
    {
        //home画面に休暇届テーブルを表示(テスト用のため適当に作成)
        $yasumiArray = $this->holidayService->getYasumiArray();
        $yasumiArray = json_encode($yasumiArray);
        return view('holidayApplication', compact('yasumiArray'));
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
    public function saveHolidayApplication(HolidayApplicationPostReq $req)
    {
        $params = $req->all();
        
        $this->holidayService->saveHoliday($params);

        return redirect('holiday');
    }

}
