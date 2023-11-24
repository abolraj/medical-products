<?php

namespace DB;

class DB extends DBMS
{
    /**
     * The default DBMS class
     *
     * @var string
     */
    private static string $dbms;

    /**
     * Set the DBMS class
     *
     * @param string $dbms The DBMS::class
     * @return void
     */
    public static function set_dbms($dbms)
    {
        self::$dbms = $dbms;
    }

    public static function connect(): bool
    {
        return self::$dbms::connect();
    }

    public static function disconnect(): bool
    {
        return self::$dbms::disconnect();
    }

    public static function query($query)
    {
        return self::$dbms::query($query);
    }

    public static function fetch($is_assoc = true): array
    {
        return self::$dbms::fetch($is_assoc);
    }

    public static function fetch_all($is_assoc = true): array
    {
        return self::$dbms::fetch_all($is_assoc);
    }


    /**
     * Create - CRUD Operations
     * You can insert a row with specified data to the table by its name
     * 
     * @param string $table Table name
     * @param array $data
     * @return void
     */
    public static function insert($table, $data)
    {
        self::query(sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s)',
            $table,
            implode(',', array_keys($data)),
            implode(',', array_values($data)),
        ));
    }

    /**
     * Read - CRUD Operations
     * You can read records from the database based on the provided conditions and arguments
     *
     * @param string $table Table name
     * @param array $where The conditions for the WHERE clause
     * @param array $attrs The columns to be selected. Defaults to ['*'] if not provided.
     * @param array $args Additional query arguments such as order by, limit, and offset. Defaults to an empty array if not provided.  supported arguments are : order_by, limit, offset(zero-indxed)
     * @return array Returns the related rows (output)
     */
    public static function select($table, $where, $attrs = ['*'], $args = []): array
    {
        $args_query = '';
        
        // Order by statement
        if (isset($args['order_by'])) {
            $args_query .= ' ORDER BY ' . $args['order_by'];
        }

        // Limit statement
        if (isset($args['limit'])) {
            $args_query .= ' LIMIT ';

            // Offset
            if (isset($args['offset'])) {
                $args_query .= $args['offset'] . ',';
            }

            $args_query .= $args['limit'];
        }

        self::query(sprintf(
            'SELECT %s FROM `%s` WHERE (%s) %s',
            implode(',', $attrs),
            $table,
            implode(',', $where),
            $args_query,
        ));

        return self::fetch_all();
    }


    /**
     * Update - CRUD Operations
     * You can update your records with conditions
     *
     * @param string $table Table name
     * @param array $data
     * @param array $where
     * @return void
     */
    public static function update($table, $data, $where)
    {
        self::query(sprintf(
            'UPDATE `%s` SET %s WHERE (%s)',
            $table,
            implode(',', $data),
            implode(',', $where),
        ));
    }

    /**
     * Delete - CRUD Operations
     * You can delete your wanted row
     *
     * @param string $table Table name
     * @param array $where
     * @return void
     */
    public static function delete($table, $where)
    {
        self::query(sprintf(
            'DELETE FROM `%s` WHERE (%s)',
            $table,
            implode(',', $where),
        ));
    }

    /**
     * You can fetch first relevant row from your table
     *
     * @param string $table Table
     * @param array $where Conditions
     * @param array $attrs Output columns
     * @param integer $offset Offset the row to select
     * @return array Returns related row as an assocciatvie array
     */
    public static function find($table, $where, $attrs = ['*'], $offset = 1): array
    {
        self::query(sprintf(
            'SELECT %s FROM `%s` WHERE (%s) LIMIT %s,1',
            implode(',', $attrs),
            $table,
            $offset,
        ));

        return self::fetch();
    }

    /**
     * Get all records from the table
     *
     * @param string $table Table name
     * @param array $attrs Output columns
     * @return array Returns related row as an assocciatvie array
     */
    public static function all($table, $attrs = ['*']): array
    {
        self::query(sprintf(
            'SELECT %s FROM `%s`',
            implode(',', $attrs),
            $table
        ));

        return self::fetch_all();
    }
}
