<?php

namespace Cache;

class MemcachedDriver extends CacheDriver
{
    private static \Memcached $memcached;
    public static function connect(): bool
    {
        static::$memcached = new \Memcached;
        return static::$memcached->addServer(static::$settings['host'], static::$settings['port']);
    }

    public static function disconnect(): bool
    {
        return static::$memcached->quit();
    }

    public static function get($key, $default = null): mixed
    {
        $value = static::$memcached->get($key);
        if(static::$memcached->getResultCode() === \Memcached::RES_NOTFOUND)
            return $default;
        return $value;
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        return static::$memcached->set($key, $value, $time_to_live);
    }

    public static function destroy($key): bool
    {
        return static::$memcached->delete($key);
    }
}
