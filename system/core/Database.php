<?php

/*
 * Используется Doctrine (DBAL) v.3
 * Документация: https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/introduction.html#introduction
 */

namespace system\core;
use system\libs\Singleton;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Database
{
    use Singleton;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private static $connection;
    /**
     * @var \Doctrine\DBAL\Query\QueryBuilder
     */
    private static $builder;

    /**
     * Создание соединения и конструктора запросов
     * и определение их в статические переменные класса
     */
    private function __construct()
    {
        $config = new Configuration();

        /*
         * Прочитать о других драйверах в подключении можете
         * вот тут: https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#configuration
         */

        try {
            $connection = DriverManager::getConnection(CONFIGURE_DATABASE, $config);
            self::$builder = $connection->createQueryBuilder();
            return self::$connection = $connection;

        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Создание соединения
     * @return \Doctrine\DBAL\Connection|Database
     */
    public static function initializeDatabase()
    {
        if(empty(self::$connection)){
            return self::$connection = new self();
        }else{
            return self::$connection;
        }
    }

    /**
     * Получение конструктора запросов
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public static function getInstanceBuilder()
    {
        return self::$builder;
    }

}