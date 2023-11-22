<?php

namespace Cache;

class MemcachedDriver extends CacheDriver
{
    private static \Memcached $memcached;
    public static function connect(): bool
    {
        self::$memcached = new \Memcached;
        return self::$memcached->addServer(self::$settings['host'], self::$settings['port']);
    }

    public static function disconnect(): bool
    {
        return self::$memcached->quit();
    }

    public static function get($key, $default = null): mixed
    {
        $value = self::$memcached->get($key);
        if(self::$memcached->getResultCode() === \Memcached::RES_NOTFOUND)
            return $default;
        return $value;
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        return self::$memcached->set($key, $value, $time_to_live);
    }

    public static function destroy($key): bool
    {
        return self::$memcached->delete($key);
    }
}
