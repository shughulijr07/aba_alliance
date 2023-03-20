<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
        public function redirectTo(){
        $role_id = Auth::user()->role_id;
        $user_status = Auth::user()->status;
        $staff = Auth::user()->staff;


        if( isset($staff->id) && $staff->staff_status == 'Active' && $user_status == 'active' ){

            switch ($role_id){ // check tha value or role_id in system_roles table
                case 1: return '/super-administrator'; break;
                case 2: return '/managing-director'; break;
                case 3: return '/human-resource-manager'; break;
                case 4: return '/accountant'; break;
                case 5: return '/supervisor'; break;
                case 6: return '/employee'; break;
                case 7: return '/system-administrator'; break;
                case 8: return '/system-administrator'; break;
                case 9: return '/finance-director'; break;
                default: return '/login'; break;
            }


        }else if($role_id ==  1){
            return '/super-administrator';
        }
        else{
            return '/login';
        }

    }

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
