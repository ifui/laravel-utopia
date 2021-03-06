<?php

$api = app('Dingo\Api\Routing\Router');

$params_v1 = [
    'version' => 'v1',
    'namespace' => 'Modules\Article\Http\Controllers\Admin',
    'prefix' => 'admin/article',
];

$api->group($params_v1, function ($api) {

    $api->group(['middleware' => 'auth:admin'], function ($api) {
        // 分类
        $api->resource('categories', 'ArticleCategoryController');
        // 内容
        $api->resource('articles', 'ArticleController');
        // 内容 批量删除
        $api->delete('articles', 'ArticleController@batch');
        // 标签
        $api->resource('tags', 'TagController');
        $api->delete('tags', 'TagController@batch');

    });
});
