<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
];

$api->group($params_v1, function ($api) {
    $api->group(['namespace' => 'Auth'], function ($api) {
        // 登录
        $api->post('login', 'AuthController@login')->name('admin.login');
        // 注册用户
        $api->post('register', 'AuthController@register')->name('admin.register');
        // 退出登录
        $api->get('logout', 'AuthController@logout')->name('admin.logout');
        // 刷新令牌
        $api->get('refresh', 'AuthController@refresh')->name('admin.refresh');
        // 用户信息
        $api->group(['middleware' => 'auth:admin'], function ($api) {
            $api->get('user', 'UserController@index');
            $api->put('user', 'UserController@update');
        });
        // 忘记密码 > 更新密码
        $api->post('password/update', 'PasswordController@update')->name('admin.password.update');
        // 发送忘记密码邮件, 访问节流限制 1 分钟 1 次
        $api->post('password/email', 'PasswordController@email')->middleware('throttle:1,1')->name('admin.password.email');
    });
});
