<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Video\Http\Controllers',
    'prefix' => 'admin/video',
];

$api->group($params_v1, function ($api) {
    // 无需权限
    $api->get('/', function () {
        return 'module video admin is working.';
    });

    $api->group(['middleware' => 'auth:admin'], function ($api) {
        // 需要权限
    });
});
