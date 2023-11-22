<?php
namespace Cache;

use Predis\Autoloader;
use Predis\Client;

Autoloader::register();

class RedisDriver extends CacheDriver {
    private static Client $client = null;
    public static function connect(): bool
    {
        self::$client = new Client([
            'host' => self::$settings['host'],
            'port' => self::$settings['port'],
        ]);

        if($pass = self::$settings['password']){
            self::$client -> auth($pass);
        }

        return true;
    }

    public static function disconnect(): bool
    {
        return !!self::$client -> disconnect();
    }

    public static function get($key, $default = null): mixed
    {
        return @unserialize(self::$client -> get($key)) ?? $default;
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        $time_to_live = $time_to_live ?: self::$ttl;
        $s_value = serialize($value);
        self::$client -> set($key, $s_value, null, $time_to_live);

        return true;
    }

    public static function destroy($key): bool
    {
        return self::$client -> del($key) ;
    }
}