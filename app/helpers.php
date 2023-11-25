<?php

// Constants

// Const - Directories

use Dotenv\Dotenv;

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
// Load the .env
$dotenv = Dotenv::createImmutable(DIR_ROOT);
$dotenv->load();


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
    return json_decode($config_json, 1);
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
        $files = array_filter($files, function($file) use ($exclude){
            return !in_array(pathinfo($file, PATHINFO_FILENAME), $exclude);
        });
    }
    foreach($files as $file)
        require_once($file);
}

// Storage functionalities 

/**
 * Store the file in the project storage with hashed name
 *
 * @param string $path The path of the file that will move
 * @param string $storage_dir The director in storage e.g. /images (implies to storage/images)
 * @return string
 */
function store($path, $storage_dir): string{
    $file_info = pathinfo($path);
    $unique_name = md5(file_get_contents($path));
    $unique_name .= '.'.$file_info['extension'];
    $dir = DIR_STORAGE . $storage_dir;
    if(!file_exists($dir)){
        mkdir($dir, 0777, true);
    }
    $detination_path =  $dir . '/' . $unique_name;
    copy($path, $detination_path);
    return $unique_name;
}

/**
 * Read the file from project storage and returns the path
 *
 * @param string $unique_name The unique name of the file
 * @param string $storage_dir The director in storage e.g. /images (implies to storage/images)
 * @return void
 */
function path($unique_name, $storage_dir){
    return DIR_STORAGE . $storage_dir . '/' . $unique_name;
}

/**
 * Show the view in relevant path with data
 *
 * @param string $path e.g. layout/main implies to path /views/layout/main.php
 * @param array $data The data passed to the view
 * @return void
 */
function view($path, $data = []){
    $path = DIR_VIEWS . '/' . $path . '.php';
    extract($data);
    require($path);
}