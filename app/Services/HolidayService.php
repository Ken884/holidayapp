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
    public function saveHoliday($params)
    {

        DB::transaction(function () use ($params) {
            //休暇届テーブルにデータを保存
            $holidayapp = new HolidayApplication;
            $holidayapp->employee_id = Auth::id();
            $holidayapp->submit_datetime = Carbon::now();
            $holidayapp->holiday_type_id = $params['holiday_type_id'];
            $holidayapp->reason = $params['reason'];
            $holidayapp->remarks = $params['remarks'];
            $holidayapp->application_status_id = 1;
            //dd($holidayapp);
            $holidayapp->save();

            //休暇日時テーブルにデータを保存
            $fromdate = new Carbon($params['holiday_date_from']);
            $todate = new Carbon($params['holiday_date_to'] ?? $params['holiday_date_from']);
            $period = CarbonPeriod::create($fromdate, $todate);

            foreach ($period as $date) {
                if (($date->dayOfWeek != 0) && ($date->dayOfWeek != 6) && !($this->yasumiService->isHoliday($date))) {
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

    //Ajaxで受け取った日付から土日祝日を除いた期間を返す
    public function getDuration($params)
    {
        $fromdate = new Carbon($params['holiday_date_from']);
        $todate = new Carbon($params['holiday_date_to']);
        $period = CarbonPeriod::create($fromdate, $todate);
        $days = 0;
        if ($fromdate <= $todate) {
            foreach ($period as $date) {
                if (($date->dayOfWeek != 0) && ($date->dayOfWeek != 6) && !($this->yasumiService->isHoliday($date))) {
                    $days++;
                }
            }
        } else {
            $days = "エラー";
        }
        return $days;
    }

    public function getYasumiArray()
    {
        $previous = Carbon::now()->subYear();
        $previousYasumis = $this->yasumiService->getYasumis(($previous->year));

        $now = Carbon::now();
        $thisYasumis = $this->yasumiService->getYasumis($now->year);

        $next = Carbon::now()->addYear();
        $nextYasumis = $this->yasumiService->getYasumis($next->year);

        foreach ($previousYasumis as $previousYasumi) {
            $yasumis[] = $previousYasumi->format('Y-m-d');
        }


        foreach ($thisYasumis as $thisYasumi) {
            $yasumis[] = $thisYasumi->format('Y-m-d');
        }

        foreach ($nextYasumis as $nextYasumi) {
            $yasumis[] = $nextYasumi->format('Y-m-d');
        }

        return $yasumis;
    }
}
