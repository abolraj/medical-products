<?php

namespace Cache;

use Predis\Autoloader;
use Predis\Client;

class RedisDriver extends CacheDriver
{
    private static Client $client;
    public static function connect(): bool
    {
        static::$client = new Client([
            'host' => static::$settings['host'],
            'port' => static::$settings['port'],
        ]);

        if ($pass = @static::$settings['password']) {
            static::$client->auth($pass);
        }

        return true;
    }

    public static function disconnect(): bool
    {
        return !!static::$client->disconnect();
    }

    public static function get($key, $default = null): mixed
    {
        return @unserialize(static::$client->get($key)) ?? $default;
    }

    public static function set($key, $value, $time_to_live = null): bool
    {
        $time_to_live = $time_to_live ?: static::$ttl;
        $s_value = serialize($value);
        if ($time_to_live)
            static::$client->setex($key, $time_to_live, $s_value);
        else
            static::$client->set($key, $s_value);

        return true;
    }

    public static function destroy($key): bool
    {
        return static::$client->del($key);
    }
}
