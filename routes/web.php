<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('holiday', 'HolidayApplicationController@index')->name('holiday_edit');
Route::post('holiday', 'HolidayApplicationController@saveHolidayApplication')->name('holiday_save')->middleware('auth');
