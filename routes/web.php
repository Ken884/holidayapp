<?php

use App\Http\Controllers\HolidayApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HolidaySaveMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/holidayapplications', 'HolidayApplicationController@index')->name('holiday_home');

    Route::get('/holidayapplications/new', 'HolidayApplicationController@holiday_create')->name('holiday_create');

    Route::get('holidayapplications/{holidayApplication}', 'HolidayApplicationController@holiday_show')->name('holiday_show');

    //AJAXでリクエストを受け取り土日祝日を除いた期間の表示
    Route::get('getDuration', 'HolidayApplicationController@duration');
    //休暇届申請
    Route::post('holiday', 'HolidayApplicationController@saveHolidayApplication')->name('holiday_save');
});


