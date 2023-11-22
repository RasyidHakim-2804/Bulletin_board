<?php
namespace Database;

use PDO;
use PDOException;

class DB
{   
    public function initialize()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        try {
            return new PDO(
                dsn: "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                username:$_ENV['DB_USERNAME'],
                password:$_ENV['DB_PASSWORD'],
                options: $options
            );
        } catch (PDOException $e) {
            die('Could not connect to the database: ' . $e->getMessage());
        }
    }

}
