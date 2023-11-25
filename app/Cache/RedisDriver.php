<?php
namespace Cache;

use Predis\Autoloader;
use Predis\Client;

Autoloader::register();

class RedisDriver extends CacheDriver {
    private static Client $client;
    public static function connect(): bool
    {
        static::$client = new Client([
            'host' => static::$settings['host'],
            'port' => static::$settings['port'],
        ]);

        if($pass = @static::$settings['password']){
            static::$client -> auth($pass);
        }

        return true;
    }

    public static function disconnect(): bool
    {
        return !!static::$client -> disconnect();
    }

    public static function get($key, $default = null): mixed
    {
        return @unserialize(static::$client -> get($key)) ?? $default;
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        $time_to_live = $time_to_live ?: static::$ttl;
        $s_value = serialize($value);
        static::$client -> set($key, $s_value, null, $time_to_live);

        return true;
    }

    public static function destroy($key): bool
    {
        return static::$client -> del($key) ;
    }
}