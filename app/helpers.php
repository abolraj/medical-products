<?php

/**
 * Get the environment variable
 *
 * @param string $key
 * @param mixed $default
 * @return void
 */
function env($key, $default = null){
    return $_ENV[$key] ?? $default;
}

