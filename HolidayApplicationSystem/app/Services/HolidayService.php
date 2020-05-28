<?php

namespace App\Services;

use DB;
use App\HolidayApplication;
use App\HolidayClass;
use App\HolidayDateTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yasumi\Yasumi;
use App\Services\YasumiService;
use Auth;

class HolidayService
{
    protected $yasumiService;
    public function __construct(YasumiService $yasumiService)
    {
        $this->yasumiService = $yasumiService;
    }
    public function saveHoliday($params){
        
        DB::transaction(function() use($params) {
            //休暇届テーブルにデータを保存
        $holidayapp = new HolidayApplication;
        $holidayapp->employee_id = Auth::id();
        $holidayapp->submit_date = Carbon::now();
        $holidayapp->holiday_class_common_id = $params['holiday_class_common_id'];
        $holidayapp->reason = $params['reason'];
        $holidayapp->remarks = $params['remarks'];
        $holidayapp->appliication_status = 0;
        //dd($holidayapp);
        $holidayapp->save();

        //休暇日時テーブルにデータを保存
        $fromdate = new Carbon($params['holiday_date_from']);
        $todate = new Carbon($params['holiday_date_to'] ?? $params['holiday_date_from']);
        $period = CarbonPeriod::create($fromdate, $todate);

        foreach($period as $date){
            if( ($date->dayOfWeek != 0) && ($date->dayOfWeek != 6) && !($this->yasumiService->isHoliday($date)) )
            {
            $holidayDatetime = new HolidayDatetime();
            $holidayDatetime->holiday_application_id = $holidayapp->id;
            $holidayDatetime->holiday_date = $date->format('y-m-d');
            $holidayDatetime->holiday_time_from = $params['holiday_time_from'] ?? null;
            $holidayDatetime->holiday_time_to = $params['holiday_time_to'] ?? null;
            $holidayDatetime->save();
            }
        }
            // DBに保存または削除する

        }); // トランザクションここまで
    }
}
