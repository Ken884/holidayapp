<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\ExpenseApplication;
use App\Policies\ExpenseApplicationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        ExpenseApplication::class => ExpenseApplicationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //管理者権限
        Gate::define('admin', function ($user) {
            return $user->role->id <= 2;
        });

        //休暇届関連
        //修正権限
        Gate::define('edit_holiday', function($user, $holidayApplication) {
            return $user->id == $holidayApplication->employee_id;
        });

        //詳細画面アクセス権限
        Gate::define('view_holiday', function($user, $holidayApplication) {
            return $user->can('edit_holiday', $holidayApplication) || $user->can('admin');
        });

        //経費精算関係
        //修正権限
        Gate::define('edit_expense', 'App\Policies\ExpenseApplicationPolicy@view');

        //詳細画面アクセス権限
        Gate::define('view_expense', function ($user, $expenseApplication) {
            return $user->can('edit_expense', $expenseApplication) || $user->can('admin');
        });
        
    }
}
