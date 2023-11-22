<?php

namespace DB;

class MySQL extends DBMS
{
    private static \PDO $pdo = null;
    private static \PDOStatement $pdo_statement = null;

    public static function connect(): bool
    {
        self::$pdo = new \PDO(sprintf("mysql:host=%s;dbname=%s", self::$host, self::$db_name), self::$username, self::$password);
        return true;
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

    public static function fetchAll($is_assoc = true): array
    {
        return self::$pdo_statement->fetchAll($is_assoc ? \PDO::FETCH_ASSOC : \PDO::FETCH_NUM);
    }
}
