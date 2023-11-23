<?php

use DB\DB;

abstract class Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static string $table = '';

    /**
     * Get table name
     *
     * @return string
     */
    public static function get_table_name(): string
    {
        return self::$table;
    }

    /**
     * Create - CRUD Operation
     * Add the entity row to the model with the data
     *
     * @param array $data
     * @return void
     */
    public static function create($data)
    {
        DB::insert(
            self::get_table_name(),
            $data
        );
    }

    /**   
     * Read - CRUD Operation
     * Read the data about the entity
     *
     * @param array $attrs
     * @param array $where
     * @param array $args
     * @return array
     */
    public static function read($attrs, $where, $args = []): array
    {
        return DB::select(
            self::get_table_name(),
            $where,
            $attrs,
            $args,
        );
    }

    /**
     * Update - CRUD Operation
     * Update the info form the entity
     *
     * @param array $data
     * @param array $where
     * @return void
     */
    public static function update($data, $where)
    {
        DB::update(
            self::get_table_name(),
            $data,
            $where,
        );
    }

    /**
     * Delete - CRUD Operation
     * Delete the entity with the condition from the info
     *
     * @param array $where
     * @return void
     */
    public static function delete($where)
    {
        DB::delete(
            self::get_table_name(),
            $where,
        );
    }
}
