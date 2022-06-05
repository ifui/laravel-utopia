<?php

namespace App\QueryBuilder;

use App\Interfaces\QueryBuilderBase;
use Spatie\QueryBuilder\AllowedFilter;

class AdminUserQuery implements QueryBuilderBase
{
    public static function include(): array
    {
        return ['roles', 'permissions'];
    }

    public static function append()
    {
        return [];
    }

    public static function field()
    {
        return [];
    }

    public static function filter()
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('sex'),
            'username',
            'nickname',
            'email',
            'phone'
        ];
    }

    public static function sort()
    {
        return ['updated_at', 'created_at', 'id'];
    }
}
