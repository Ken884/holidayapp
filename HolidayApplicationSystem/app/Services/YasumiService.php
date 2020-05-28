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
    public function isHoliday($date){
        $holidays = Yasumi::create('Japan', $date->year);
        return $holidays->isHoliday($date);
    }

    public function getThisYasumis(){
        $now = Carbon::now();
        return $holidays = Yasumi::create('Japan', $now->year);
    }

    public function getNextYasumis(){
        $now = Carbon::now();
        $now->addYear();
        return $holidays = Yasumi::create('Japan', $now->year);
    }
}
