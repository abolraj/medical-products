<?php

namespace Cache;

class Cache extends CacheDriver
{

    /**
     * The cache driver
     *
     * @var string
     */
    private static string $cache_driver;

    /**
     * Set the cache driver
     *
     * @param string $cache_driver
     * @return void
     */
    public static function set_cache_driver($cache_driver)
    {
        static::$cache_driver = $cache_driver;
    }

    public static function connect(): bool
    {
        return static::$cache_driver::connect();
    }

    public static function disconnect(): bool
    {
        return static::$cache_driver::disconnect();
    }


    public static function get($key, $default = null): mixed
    {
        return static::$cache_driver::get($key, $default);
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        return static::$cache_driver::set($key, $value, $time_to_live);
    }


    public static function destroy($key, $default = null): bool
    {
        return static::$cache_driver::get($key, $default);
    }
}
