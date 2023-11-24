<?php
// Load the needed scripts

// Composer
require_once(DIR_ROOT . '/vendor/autoload.php');

// Helper
require_once(DIR_ROOT . '/app/helpers.php');

// Cache
auto_require_scripts(DIR_ROOT . '/app/Cache/*', ['core']);
require_once(DIR_ROOT . '/app/Cache/core.php');

// DBMS
auto_require_scripts(DIR_ROOT . '/app/DBMS/*', ['core']);
require_once(DIR_ROOT . '/app/DBMS/core.php');

// Model
auto_require_scripts(DIR_ROOT . '/app/Model/*');



// Initialize Dependencies

// Load envirnoment variables
$dot_env = \Dotenv\Dotenv::createImmutable(DIR_ROOT);
$dot_env->load();
