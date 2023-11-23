<?php
// Require the needed scripts

// Composer
require_once(DIR_ROOT . '/vendor/autoload.php');

// Helper
require_once(DIR_ROOT . '/app/helper.php');

// Cache
auto_require_scripts(DIR_ROOT . '/app/Cache/*', ['core']);
require_once(DIR_ROOT . '/app/Cache/core.php');

// DBMS
auto_require_scripts(DIR_ROOT . '/app/Cache/*', ['core']);
require_once(DIR_ROOT . '/app/DBMS/core.php');

// Model
require_once(DIR_ROOT . '/app/Model/*');
