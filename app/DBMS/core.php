<?php
namespace DB;
require_once(DIR_APP . '/DBMS/DBMS.php');
require_once(DIR_APP . '/DBMS/MySQL.php');
require_once(DIR_APP . '/DBMS/DB.php');

$db_config = get_config('database');
// Config JSON Schema (Last Update)
// {
//     "db" : "db-name",
//     "dbms" : "mysql",
//     "dbs" : {
//         "db-name" : {
//             "host": "host",
//             "username" : "db-user-name",
//             "password" : "db-password"
//         }
//     }
// }

define('DB_NAME', $db_config);

if (!DB_NAME || !in_array(DB_NAME, array_keys($db_config['dbs']))) {
    die('DB Err: No DB found in config.database.dbs');
}

if ($db_config['dbms'] === 'mysql') {
    MySQL::config($db_config['dbs'][DB_NAME]);
    MYSQL::set_db(DB_NAME);
    MySQL::connect();

    DB::set_DBMS(MySQL::class);
}
