<?php

namespace App\Helpers;

class DateTimeHelper
{
    /* YYYY-MM-DD(dd)形式の文字列をYYYY-MM-DDにパースする
     * @params string $param
     * @return string 
     */
    public static function parseDate($param){

        $dateArr = preg_split('/\s/', $param);
        return $dateArr[0];
    }
}