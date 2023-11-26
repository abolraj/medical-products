<?php

// Constants

// Const - Directories

use Dotenv\Dotenv;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

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

/**
 * Show the view in relevant path with data end extend basic layout
 *
 * @param string $main e.g. layout/main implies to path /views/layout/main.php will included
 * @param array $data The data passed to the view
 * @param bool $has_layout The layout parent passed
 * @return void
 */
function render($main_path, $data = [], $has_layout = true){
    $data = array_merge($data, [
        'main_path' => $main_path,
        'has_layout' => $has_layout,
    ]);
    $data = array_merge($data, ['data' => $data]);
    view('layout/index', $data);
}

/**
 * Set the temporary data
 *
 * @param string $key
 * @param string $value
 * @param integer $ttl
 * @return void
 */
function set_temp_data($key, $value, $ttl = 60){
    $en_value = base64_encode($value);
    $hashed_key = md5(env('APP_NAME','APP_NAME') . $key);
    
    setcookie($hashed_key, $en_value, time() + $ttl, '/');
}

/**
 * Get the temporary data
 *
 * @param string $key
 * @param string $default
 * @param bool $pop True, will delete the data after getting
 * @return mixed
 */
function get_temp_data($key, $default = null, $pop = false): mixed{
    $hashed_key = md5(env('APP_NAME','APP_NAME') . $key);
    if(!isset($_COOKIE[$hashed_key]))
        return $default;
    $value = base64_decode($_COOKIE[$hashed_key]);
    if($pop){
        unset($_COOKIE[$hashed_key]);
        setcookie($hashed_key, null, time()-3600, '/');
    }
    return $value;
}

/**
 * Retrieve and delete the data
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function pop_temp_data($key, $default = null): mixed{
    return get_temp_data($key, $default, true);
}



/**
 * The helper functions for router
 */

/**
 * Get url for a route by using either name/alias, class or method name.
 *
 * The name parameter supports the following values:
 * - Route name
 * - Controller/resource name (with or without method)
 * - Controller class name
 *
 * When searching for controller/resource by name, you can use this syntax "route.name@method".
 * You can also use the same syntax when searching for a specific controller-class "MyController@home".
 * If no arguments is specified, it will return the url for the current loaded route.
 *
 * @param string|null $name
 * @param string|array|null $parameters
 * @param array|null $getParams
 * @return \Pecee\Http\Url
 * @throws \InvalidArgumentException
 */
function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

/**
 * @return \Pecee\Http\Response
 */
function response(): Response
{
    return Router::response();
}

/**
 * @return \Pecee\Http\Request
 */
function request(): Request
{
    return Router::request();
}

/**
 * Get input class
 * @param string|null $index Parameter index name
 * @param string|mixed|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return \Pecee\Http\Input\InputHandler|array|string|null
 */
function input($index = null, $defaultValue = null, ...$methods)
{
    if ($index !== null) {
        return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
    }

    return request()->getInputHandler();
}

/**
 * @param string $url
 * @param int|null $code
 */
function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }

    response()->redirect($url);
}

/**
 * Get current csrf-token
 * @return string|null
 */
function csrf_token(): ?string
{
    $baseVerifier = Router::router()->getCsrfVerifier();
    if ($baseVerifier !== null) {
        return $baseVerifier->getTokenProvider()->getToken();
    }

    return null;
}

function get_asset($asset_path){
    return '/assets' . $asset_path;
}