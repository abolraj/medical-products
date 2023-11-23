<?php

// Constants

// Const - Directories
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

/**
 * Require the php files in the directory automaticly
 * Note that the non-global variables will not load !
 *
 * @param string $directory
 * @param array $exclude
 * @return void
 */
function auto_require_scripts($directory_pattern, $exclude = []) {
    $files = glob($directory_pattern . '/*.php');
    
    // Exclude files
    if(!empty($exclude)){
        $exclude_p = implode('|', $exclude);
        $exclude_p = "(".$exclude_p.")\.php$";
        $files = preg_grep("/$exclude_p/", $files, PREG_GREP_INVERT);
    }

    foreach($files as $file)
        require_once($file);
}