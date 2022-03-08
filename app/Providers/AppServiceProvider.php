<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // 当角色为 super-admin 时，can() 方法返回 true
        // 当权限为 administrator 时，can() 方法返回 true
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
            if ($user->hasPermissionTo('administrator')) {
                return true;
            }
            return null;
        });
    }
}
