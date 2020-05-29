<?php

namespace App\Services;

use DB;
use App\HolidayApplication;
use App\HolidayClass;
use App\HolidayDateTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yasumi\Yasumi;

class YasumiService
{
    public function isHoliday($date)
    {
        $holidays = Yasumi::create('Japan', $date->year);
        return $holidays->isHoliday($date);
    }


    public function getYasumis($year)
    {
        $now = Carbon::create($year);
        $holidays = Yasumi::create('Japan', $year);
        return $holidays;
    }

    
}
