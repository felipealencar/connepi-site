<?php

class DB extends PDO
{
    private static $db = null;

    public static function init()
    {
        if (is_null(self::$db) === true)
        {
            self::$db = new PDO( "pgsql:dbname=ocs; user=postgres; password=postgres; host=localhost; port=5432" );
        }

        return self::$db;
    }
}

?>