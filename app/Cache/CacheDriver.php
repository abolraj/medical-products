<?php

namespace Cache;

abstract class CacheDriver
{
    /**
     * The default settings setted from relevant config files
     *
     * @var array
     */
    protected static array $settings = [];

    /**
     * Time To Live
     *
     * @var integer
     */
    protected int $ttl = 3600;

    /**
     * Connect to the cache server
     *
     * @return bool Returns true on success and false on failure
     */
    public static abstract function connect(): bool;

    /**
     * Disonnect from the cache server
     *
     * @return bool Returns true on success and false on failure
     */
    public static abstract function disconnect(): bool;

    /**
     * Set the config
     *
     * @param array $settings
     * @return array
     */
    public static function config($settings): array
    {
        static::$settings = $settings;

        return static::$settings;
    }

    /**
     * Get the cached value by key
     *
     * @param string $key
     * @param mixed $default
     * @return string|bool
     */
    public static abstract function get($key, $default = null): mixed;

    /**
     * Set the cached value by key
     *
     * @param string $key
     * @param mixed $value
     * @param int $time_to_live Amount of time this cache value will be alive 
     * @return boolean Returns true on success and false on failure
     */
    public static abstract function set($key, $value, $time_to_live = null): bool;

    /**
     * Destroy the cached value by key
     *
     * @param string $key
     * @return boolean
     */
    public static abstract function destroy($key): bool;

    /**
     * Retrieve the cached value by key and destroy it !
     *
     * @param string $key
     * @param mixed $default
     * @return string|bool
     */
    public static function pop($key, $default = null): string | bool
    {
        $value = static::get($key, $default);
        if ($value === false)
            return false;

        static::destroy($key);
        return $value;
    }
}
