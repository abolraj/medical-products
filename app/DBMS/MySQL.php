<?php

namespace DB;

class MySQL extends DBMS
{
    /**
     * The PDO object to handle DBMS functionalities
     *
     * @var \PDO
     */
    private static \PDO $pdo = null;

    /**
     * The PDOStatement for handling query results
     *
     * @var \PDOStatement
     */
    private static \PDOStatement $pdo_statement = null;

    public static function connect(): bool
    {
        try {
            self::$pdo = new \PDO(sprintf("mysql:host=%s;dbname=%s", self::$host, self::$db_name), self::$username, self::$password);
            self::$pdo -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch(\PDOException $e) {
            die('PDO MySQL Err : ' . $e->getMessage());
            return false;
        }
    }

    public static function disconnect(): bool
    {
        self::$pdo = null;
        return true;
    }

    public static function query($query)
    {
        self::$pdo_statement = self::$pdo->query($query);
    }

    public static function fetch($is_assoc = true): array
    {
        return self::$pdo_statement->fetch($is_assoc ? \PDO::FETCH_ASSOC : \PDO::FETCH_NUM);
    }

    public static function fetch_all($is_assoc = true): array
    {
        return self::$pdo_statement->fetchAll($is_assoc ? \PDO::FETCH_ASSOC : \PDO::FETCH_NUM);
    }
}
