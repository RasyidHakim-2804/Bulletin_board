<?php
namespace App\Core;

use \mysqli;

abstract class Model
{
    private const SERVER   = "localhost";
    private const USER     = "root";
    private const PASSWORD = "rootRoot";
    private const DATABASE = "bulletin_board";
    private static $connection;
 
    
    protected static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(self::SERVER, self::USER, self::PASSWORD, self::DATABASE);
            
            if (self::$connection->connect_error) {
                die('Failed to connect to MySQL:' . ' ' . self::$connection->connect_error);      
            }
        }
        
        return self::$connection;
    }

    protected static function myQuery($query) 
    {
        $result = self::getConnection()->query($query);
        
        if (!$result) {
            echo 'Error description:' . ' ' . self::getConnection()->error;
            return false;
        }
        
        return $result;
    }


    protected static function myAssoc($table)
    {
        $data = [];

        while ($row = $table->fetch_assoc()) {
            $data[] = $row; 
        }

        return $data;
    }



    protected static function myEscapeString(string $input)
    {
        return self::getConnection()->real_escape_string($input);
    }


    protected static function myClose()
    {
        self::getConnection()->close();
    }
}
