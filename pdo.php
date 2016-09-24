<?php

class DB extends PDO
{
    private static $db = null;

    public static function init()
    {
        if (is_null(self::$db) === true)
        {
            // self::$db = new PDO( "pgsql:dbname=ocs; user=sistema_ocs; password=10s#th7if@l; host=192.168.253.46; port=5432" );
						self::$db = new PDO("pgsql:dbname=ocs; user=postgres; password=2165162; host=localhost; port=5432");
        }

        return self::$db;
    }
}

?>
