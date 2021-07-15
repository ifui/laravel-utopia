<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Video\Http\Controllers',
    'prefix' => 'video',
];

$api->group($params_v1, function ($api) {
    // 无需权限
    $api->get('/', function () {
        return 'module video is working.';
    });

    $api->group(['middleware' => 'auth:api'], function ($api) {
        // 需要权限
    });
});
