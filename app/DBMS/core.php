<?php
namespace DB;
require_once(DIR_APP . '/DBMS/DBMS.php');
auto_require_scripts(DIR_APP . '/DBMS', ['core', 'DBMS']);

$db_config = get_config('database');
// Config JSON Schema (Last Update)
// {
//     "db" : "db-name",
//     "dbms" : "mysql",
//     "dbmses" : {
//         "dbms-name" : {
//             "host": "host",
//             "username" : "db-user-name",
//             "password" : "db-password"
//         }
//     }
// }

define('DBMS_NAME', $db_config['dbms']);

if (!DBMS_NAME || !in_array(DBMS_NAME, array_keys($db_config['dbmses']))) {
    die('DB Err: No DBMS found in config.database.dbmses');
}

if ($db_config['dbms'] === 'mysql') {
    MySQL::config($db_config['dbmses'][DBMS_NAME]);
    MYSQL::set_db($db_config['db']);
    MySQL::connect();

    DB::set_dbms(MySQL::class);
}
