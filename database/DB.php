<?php
namespace Database;

use PDO;
use PDOException;

class DB
{   
    public static function initialize()
    {
        try {
            return new PDO(
                dsn: "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                username:$_ENV['DB_USERNAME'],
                password:$_ENV['DB_PASSWORD']
            );
        } catch (PDOException $e) {
            die('Could not connect to the database:' . $e->getMessage());
        }
    }

}
