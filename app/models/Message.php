<?php
namespace App\Models;

use App\Core\Database;

class Message extends Database
{
  
  public static function get()
  {
    $table = Database::myQuery("SELECT * FROM message ORDER BY id DESC");
    $row   = Database::myAssoc($table);
    
    Database::myClose();

    return $row;
  }

  public static function store($message)
  {
    $value  = Database::myEscapeString($message);
    $query  = "INSERT INTO message ( body ) VALUE ('$value')";
    $result = Database::myQuery($query);

    Database::myClose();

    return $result;
  }
}