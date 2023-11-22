<?php

namespace Cache;
require_once(DIR_APP . '/Cache/CacheDriver.php');
require_once(DIR_APP . '/Cache/RedisDriver.php');
require_once(DIR_APP . '/Cache/MemcachedDriver.php');
require_once(DIR_APP . '/Cache/Cache.php');

$cache_config = get_config('cache');
// Config JSON Schema (Last Update)
// {
//     "driver" : "driver-name",
//     "drivers" : {
//         "driver-name" : {
//             "host" : "host-name",
//             "port" : "port"
//         }
//     }
// }

define('CACHE_DRIVER_NAME', $cache_config);

if (!CACHE_DRIVER_NAME || !in_array(CACHE_DRIVER_NAME, array_keys($cache_config['drivers']))) {
    die('Cache Err: No Cache Driver found in config.cache.driver');
}

// Handle the Cache Driver for redis driver
if ($cache_config['driver'] === 'redis') {
    RedisDriver::config($cache_config['drivers'][CACHE_DRIVER_NAME]);
    RedisDriver::connect();

    Cache::set_cache_driver(RedisDriver::class);
}

// Handle the Cache Driver for memcached driver
if ($cache_config['driver'] === 'memcached') {
    MemcachedDriver::config($cache_config['drivers'][CACHE_DRIVER_NAME]);
    MemcachedDriver::connect();

    Cache::set_cache_driver(RedisDriver::class);
}
