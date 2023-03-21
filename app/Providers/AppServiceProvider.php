<?php

namespace App\Providers;

use App\AdvancePaymentRequest;
use App\Http\Controllers\LeavesController;
use App\Leave;
use App\LeavePlan;
use App\PerformanceObjective;
use App\TimeSheet;
use App\TravelRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Schema;


class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('leaveRequests', Leave::countLeaveRequests());
        });

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('timeSheets', TimeSheet::countTimeSheets());
        });

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('leavePlans', LeavePlan::countLeavePlans());
        });

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('travelRequests', TravelRequest::countTravelRequests());
        });

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('performanceObjectives', PerformanceObjective::countPerformanceObjectives());
        });

        view()->composer(['layouts.administrator.admin','layouts.administrator.admin-menu'], function ($view){
            $view->with('advancePaymentRequest', AdvancePaymentRequest::countRequests());
        });

    }
}
