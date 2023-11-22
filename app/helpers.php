<?php

// Constants

// Const - Directories
define('DIR_ROOT', trim(env('APP_ROOT'), '/'));
define('DIR_APP', DIR_ROOT . '/app');
define('DIR_CONFIG', DIR_ROOT . '/config');
define('DIR_DATABASE', DIR_ROOT . '/database');
define('DIR_PUBLIC', DIR_ROOT . '/public');
define('DIR_ROUTES', DIR_ROOT . '/routes');
define('DIR_STORAGE', DIR_ROOT . '/storage');
define('DIR_VIEWS', DIR_ROOT . '/views');

/**
 * Get the environment variable
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null): mixed
{
    return $_ENV[$key] ?? $default;
}


/**
 * Get the configs array by config name
 *
 * @param string $config_name The config file name in the config directory
 * @return array Returns assocciative array from the json in the config file
 */
function get_config($config_name): array
{
    $config_file = DIR_CONFIG . "/{$config_name}.json";
    $config_json = file_get_contents($config_file);
    return json_decode($config_json);
}
