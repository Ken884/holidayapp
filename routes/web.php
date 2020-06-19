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

    //休暇申請関連
    Route::namespace('HolidayApplication')->group(function(){

        Route::get('/holidayapplications', 'HolidayApplicationController@index')->name('holiday_home');

        Route::get('/holidayapplications/new', 'HolidayApplicationController@holiday_create')->name('holiday_create');

        Route::get('holidayapplications/{holidayApplication}', 'HolidayApplicationController@holiday_show')->name('holiday_show');

        //AJAXでリクエストを受け取り土日祝日を除いた期間の表示
        Route::get('getDuration', 'HolidayApplicationController@duration');
        //休暇届申請
        Route::post('holidayapplications/new', 'HolidayApplicationController@holiday_store')->name('holiday_save');
    });

    //経費精算関連
    Route::namespace('ExpenseApplication')->group(function(){

        Route::get('/expenseapplications', 'ExpenseApplicationController@index')->name('expense_home');

        Route::get('/expenseapplications/new', 'ExpenseApplicationController@expense_create')->name('expense_create');

        Route::get('/expenseapplications/show/{expenseApplication}', 'ExpenseApplicationController@expense_show')->name('expense_show');

        Route::get('/expenseapplications/edit/{expenseApplication}', 'ExpenseApplicationController@expense_edit')->name('expense_edit');

        //経費精算書申請
        Route::post('expenseapplications/new', 'ExpenseApplicationController@expense_store')->name('expense_store');
    });
});


