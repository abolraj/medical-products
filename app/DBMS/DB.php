<?php
namespace DB;

class DB extends DBMS
{
    /**
     * The default DBMS class
     *
     * @var string
     */
    private string $dbms = null;

    /**
     * Set the DBMS class
     *
     * @param string $dbms The DBMS::class
     * @return void
     */
    public static function set_DBMS($dbms){
        self::$dbms = $dbms;
    }

    public static function connect(): bool
    {
        return $dbms::connect();
    }

    public static function disconnect(): bool
    {
        return $dbms::disconnect();
    }

    public static function query($query)
    {
        return $dbms::query($query);
    }

    public static function fetch($is_assoc = true): array
    {
        return $dbms::fetch($is_assoc);
    }

    public static function fetchAll($is_assoc = true): array
    {
        return $dbms::fetchAll($is_assoc);
    }
}
