<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'App\Http\Controllers\V1',
];

$api->group($params_v1, function ($api) {
    $api->group(['namespace' => 'Auth'], function ($api) {
        // 登录
        $api->get('login', 'AuthController@login')->name('login');
        // 注册用户
        $api->post('register', 'AuthController@register')->name('register');
        // 退出登录
        $api->get('logout', 'AuthController@logout')->name('logout');
        // 刷新令牌
        $api->get('refresh', 'AuthController@refresh')->name('refresh');
        // 用户信息
        $api->group(['middleware' => 'auth:api'], function ($api) {
            $api->get('user', 'UserController@index');
            $api->put('user', 'UserController@update');
        });
    });
});
