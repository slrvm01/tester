<?php

namespace system\base;

use Pixie;


/**
 * Class DB
 * @package system\base
 */
class DB
{
    /**
     * Database instance
     * @var null
     */
    private static $instance = null;

    /**
     * Create DB instance and return it if it's already exist
     * @return null|Pixie\QueryBuilder\QueryBuilderHandler
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            $connection = new Pixie\Connection('mysql', [
                'driver' => 'mysql',
                'host' => DB_HOST,
                'database' => DB_DATABASE,
                'username' => DB_USERNAME,
                'password' => DB_PASSWORD,
                'charset' => 'utf8'
            ]);

            try {
                self::$instance = new Pixie\QueryBuilder\QueryBuilderHandler($connection);
            } catch (Pixie\Exception $e) {
                echo $e->getMessage();
            }
        }

        return self::$instance;
    }
}