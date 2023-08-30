<?php
namespace Core;

use \PDO;

class Database
{   
    private $db;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";

            $this->db = new PDO(dsn: $dsn, username: $_ENV['DB_USERNAME'], password: $_ENV['DB_PASSWORD']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (\PDOexception $e) {
            
            die($e->getMessage());
        }
    }

    public function getDB()
    {
        return $this->db;
    }

    public function __destruct()
    {
        $this->db = null;
    }

}
