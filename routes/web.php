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

        //一覧画面表示
        Route::get('/holidayapplications', 'HolidayApplicationController@index')->name('holiday_home');

        //ユーザー用一覧絞り込み
        Route::get('userSearchHoliday', 'HolidayApplicationController@userSearch');

        //新規画面表示
        Route::get('/holidayapplications/new', 'HolidayApplicationController@holiday_create')->name('holiday_create');

        //詳細画面表示
        Route::get('holidayapplications/show/{holidayApplication}', 'HolidayApplicationController@holiday_show')
        ->middleware('can:view_holiday,holidayApplication')->name('holiday_show');

        //修正画面表示
        Route::get('/holidayapplications/edit/{holidayApplication}', 'HolidayApplicationController@holiday_edit')->name('holiday_edit');

        //AJAXでリクエストを受け取り土日祝日を除いた期間の表示
        Route::get('getDuration', 'HolidayApplicationController@duration');

        //休暇届申請
        Route::post('holidayapplications/new', 'HolidayApplicationController@holiday_store')->name('holiday_save');


        Route::middleware('can:admin')->group(function () {
            //管理者者用一覧絞り込み
            Route::get('adminSearchHoliday', 'HolidayApplicationController@adminSearch');

            Route::post('holidayapplications/show/{holidayApplication}', 'HolidayApplicationController@holiday_authorize')->name('holiday_authorize');
        });
    });

    //経費精算関連
    Route::namespace('ExpenseApplication')->group(function(){

        //一覧画面画面表示
        Route::get('/expenseapplications', 'ExpenseApplicationController@index')->name('expense_home');

        //ユーザー用一覧絞り込み
        Route::get('userSearchExpense', 'ExpenseApplicationController@userSearch');

        //新規画面表示
        Route::get('/expenseapplications/new', 'ExpenseApplicationController@expense_create')->name('expense_create');

        //詳細画面表示
        Route::get('/expenseapplications/show/{expenseApplication}', 'ExpenseApplicationController@expense_show')
        ->middleware('can:view_expense,expenseApplication')->name('expense_show');

        //修正画面表示
        Route::get('/expenseapplications/edit/{expenseApplication}', 'ExpenseApplicationController@expense_edit')->name('expense_edit');

        //経費精算書申請
        Route::post('expenseapplications/new', 'ExpenseApplicationController@expense_store')->name('expense_store');

        //管理者のみアクセス可能
        Route::middleware('can:admin')->group(function () {
            
            //管理者用一覧絞り込み
            Route::get('adminSearchExpense', 'ExpenseApplicationController@adminSearch');
            
            //承認・否認
            Route::post('expenseapplication/show/{expenseApplication}', 'ExpenseApplicationController@expense_authorize')->name('expense_authorize');
        });
    });
});


