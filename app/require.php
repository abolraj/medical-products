<?php
// Load the needed scripts

// Composer
require_once(DIR_ROOT . '/vendor/autoload.php');

// Helper
require_once(DIR_ROOT . '/app/helpers.php');

// Cache
require_once(DIR_ROOT . '/app/Cache/core.php');

// DBMS
require_once(DIR_ROOT . '/app/DBMS/core.php');

// Model
require_once(DIR_ROOT . '/app/Model/Model.php');
auto_require_scripts(DIR_ROOT . '/app/Model', ['Model']);

// HTTP Middlewares
auto_require_scripts(DIR_ROOT . '/app/HTTP/Middleware');
