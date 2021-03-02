<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Article\Http\Controllers',
    'prefix' => 'admin/article',
];

$api->group($params_v1, function ($api) {
    // 无需权限
    $api->get('/', function () {
        return 'module article admin is working.';
    });

    $api->group(['middleware' => 'auth:admin'], function ($api) {
        // 需要权限
    });
});
