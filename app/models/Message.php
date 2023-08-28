<?php
namespace App\Models;

use App\Core\Model;

class Message extends Model
{
  
  public static function get()
  {
    $table = self::getModel()::myQuery("SELECT * FROM message ORDER BY id DESC");
    $row   = self::getModel()::myAssoc($table);

    return $row;
  }

  public static function store($message)
  {
    $value  = self::getModel()::myEscapeString($message);
    $query  = "INSERT INTO message ( body ) VALUE ('$value')";
    $result = self::getModel()::myQuery($query);

    return $result;
  }
}