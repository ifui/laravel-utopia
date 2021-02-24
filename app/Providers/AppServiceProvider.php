<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
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
        //
        app('api.exception')->register(function (\Exception $exception) {
            $request = Request::capture();
            return app('App\Exceptions\Handler')->render($request, $exception);
        });

        // 重写 Dingo api
        // app(\Dingo\Api\Exception\Handler::class)->register(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
        //     return Response::make(['error' => 'Hey, what do you think you are doing!?'], 401);
        // });
    }
}
