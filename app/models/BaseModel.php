<?php

namespace app\models;
use system\core\Database;
use system\libs\Singleton;


class BaseModel
{
    protected static $query;

    use Singleton;

    private function __construct()
    {
        self::$query = Database::getInstanceBuilder();
        return self::$query;
    }

    public static function query()
    {
        if(empty(self::$query)){
            new self();
            return self::$query;
        }else{
            return self::$query;
        }
    }

}