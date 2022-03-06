<?php

namespace App\Redis;

use Illuminate\Support\Facades\Redis as FacadesRedis;
use Illuminate\Support\Str;

abstract class Redis
{

    /**
     * 添加/设置 一个 Reids
     *
     * @param string $key
     * @param [type] $value
     * @return boolean
     */
    public static function set(string $key, $value)
    {
        return FacadesRedis::set(static::createKey($key), $value);
    }

    /**
     * 添加/设置 一个 Redis 并设置过期时间
     *
     * @param string $key
     * @param integer $expires 过期时间
     * @param [type] $value
     * @return boolean
     */
    public static function setex(string $key, int $expires, $value)
    {
        return FacadesRedis::setex(static::createKey($key), $expires, $value);
    }

    /**
     * 获取一个 Reids
     *
     * @param string $key
     * @return string|null
     */
    public static function get(string $key)
    {
        return FacadesRedis::get(static::createKey($key));
    }

    /**
     * 删除一个 Redis
     *
     * @param string $key
     * @return integer
     */
    public static function del(string $key)
    {
        return FacadesRedis::del(static::createKey($key));
    }

    /**
     * 生成存储 key
     *
     * @param string $key
     * @return string
     */
    protected static function createKey(string $key)
    {
        return static::getClassName() . ':' . $key;
    }

    /**
     * 获取 class name
     * 经驼峰转下划线处理
     *
     * @return string
     */
    protected static function getClassName()
    {
        return Str::snake(Str::pluralStudly(class_basename(new static())));
    }
}
