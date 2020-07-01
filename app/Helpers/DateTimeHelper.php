<?php

namespace App\Helpers;
use App\Services\YasumiService;

class DateTimeHelper
{
    protected $yasumiService;

    public function __construct(YasumiService $yasumiService)
    {
        $this->yasumiService = $yasumiService;
    }
    
    //'YYYY-MM-dd HH:MM:SS' -> 'YYYY-MM-dd'
    public static function parseDate($param)
    {

        $dateArr = preg_split('/\s/', $param);
        return $dateArr[0];
    }

    public static function countWeekDays($array)
    {
        $fromdate = new Carbon($array[0]);
        $todate = new Carbon($array[1]);
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
}