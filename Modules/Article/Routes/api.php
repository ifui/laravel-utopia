<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Article\Http\Controllers\V1',
    'prefix' => 'article',
];

$api->group($params_v1, function ($api) {
    // 内容相关路由
    $api->get('/articles', 'ArticleController@index');
    $api->get('/articles/{id}', 'ArticleController@show');

    // 内容分类相关路由
    $api->get('/categories', 'ArticleCategoryController@index');
    $api->get('/categories/{id}', 'ArticleCategoryController@show');

    // 标签相关路由
    $api->get('/tags', 'TagController@index');
    $api->get('/tags/{id}', 'TagController@show');

    $api->group(['middleware' => 'auth:api'], function ($api) {
        // 需要权限
    });
});
