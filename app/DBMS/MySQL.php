<?php

namespace DB;

class MySQL extends DBMS
{
    /**
     * The PDO object to handle DBMS functionalities
     *
     * @var \PDO
     */
    private static \PDO $pdo;

    /**
     * The PDOStatement for handling query results
     *
     * @var \PDOStatement
     */
    private static \PDOStatement $pdo_statement;

    public static function connect(): bool
    {
        try {
            static::$pdo = new \PDO(sprintf("mysql:host=%s;dbname=%s", static::$host, static::$db_name), static::$username, static::$password);
            static::$pdo -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch(\PDOException $e) {
            die('PDO MySQL Err : ' . $e->getMessage());
            return false;
        }
    }

    public static function disconnect(): bool
    {
        static::$pdo = null;
        return true;
    }

    public static function query($query)
    {
        static::$pdo_statement = static::$pdo->query($query);
    }

    public static function fetch($is_assoc = true): array|bool
    {
        return static::$pdo_statement->fetch($is_assoc ? \PDO::FETCH_ASSOC : \PDO::FETCH_NUM);
    }

    public static function fetch_all($is_assoc = true): array|bool
    {
        return static::$pdo_statement->fetchAll($is_assoc ? \PDO::FETCH_ASSOC : \PDO::FETCH_NUM);
    }
}
