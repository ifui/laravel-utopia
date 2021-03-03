<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Article\Http\Controllers\Admin',
    'prefix' => 'admin/article',
];

$api->group($params_v1, function ($api) {

    $api->group(['middleware' => 'auth:admin'], function ($api) {
        $api->resource('categories', 'ArticleCategoryController');
    });
});
