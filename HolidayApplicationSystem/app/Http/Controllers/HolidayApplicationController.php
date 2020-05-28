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
    * 項目｢区分｣に表示する休暇区分の値を、休暇届申請作成画面に渡す
    * @param HolidayClass $holidayClass 休暇区分が格納されているモデル
    * @return response 休暇申請画面のview
    */
    public function index(HolidayClass $holidayClass){
        //home画面に休暇届テーブルを表示(テスト用のため適当に作成)
        $data1['holiday_applications']= DB::table('holiday_applications');
        $data2['holiday_datetimes']= DB::table('holiday_datetimes');

        return view('holidayApplication', compact(['holidayClass' => $holidayClass], $data1, $data2));
    }


    /**
     * 休暇届のデータを｢休暇届テーブル｣と｢休暇日時テーブル｣に保存
     * @param HolidayApplicationPostReq $req バリデーションを通過したリクエストの値
     */
    public function saveHolidayApplication(HolidayApplicationPostReq $req){
        $params = $req->all();
        $this->holidayService->saveHoliday($params);

        return redirect('home');
    }

}
