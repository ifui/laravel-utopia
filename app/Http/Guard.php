<?php

namespace App\Http;

use Illuminate\Support\Facades\Auth;

class Guard
{
    /**
     * 返回 api 认证守卫
     *
     * @return @var \Illuminate\Support\Facades\Auth $auth
     */
    public static function api()
    {
        return Auth::guard('api');
    }

    /**
     * 返回 admin 认证守卫
     *
     * @return @var \Illuminate\Support\Facades\Auth $auth
     */
    public static function admin()
    {
        return Auth::guard('admin');
    }
}
