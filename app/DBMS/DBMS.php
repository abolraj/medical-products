<?php

namespace DB;

abstract class DBMS
{
    /**
     * The host of the database server
     *
     * @var string
     */
    protected static string $host;

    /**
     * The username for accessing the database server
     *
     * @var string
     */
    protected static string $username;

    /**
     * The database name 
     *
     * @var string
     */
    protected static string $db_name;

    /**
     * The settings passed in the config file and relevant DBMS
     *
     * @var array
     */
    protected static array $settings = [];

    /**
     * The password for accessing the database server
     *
     * @var string
     */
    protected static string $password;

    public static function config($settings): array
    {
        static::$settings = $settings;
        static::$host = static::$settings['host'];
        static::$username = static::$settings['username'];
        static::$password = static::$settings['password'];

        return static::$settings;
    }

    public static function set_db($db_name): string
    {
        static::$db_name = $db_name;

        return static::$db_name;
    }


    /**
     * Connect to the database server
     *
     * @return bool Returns true on success and false on failure
     */
    abstract public static function connect(): bool;

    /**
     * Disconnect from the database server
     *
     * @return bool Returns true on success and false on failure
     */
    abstract public static function disconnect(): bool;

    /**
     * Execute a query on the database
     *
     * @param string $query The SQL query to execute
     * @return void
     */
    abstract public static function query(string $query);

    /**
     * Fetchs all the rows that executed by query function
     *
     * @param boolean $is_assoc True = associative array or False = indexed array
     * @return array Returns all rows selected or outputted by Database query
     */
    abstract public static function fetch_all($is_assoc = true): array;

    /**
     * Fetchs the row that executed by query function, you can get next row by call it again or false on no next row
     *
     * @param boolean $is_assoc True = associative array or False = indexed array
     * @return array|bool Returns row selected or outputted by Database query or False on no row
     */
    abstract public static function fetch($is_assoc = true): array|bool;
}
