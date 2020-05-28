<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppValidateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //日付フォーマットバリデーション
        Validator::extend('mydate', function($attribute, $value, $parameters, $validator)
        {
            $dateArr = preg_split('/\-|\(/', $value);
            if(count($dateArr) >= 3 ){
                return checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
            }else{
                return false;
            }
            
        });
    }
}
