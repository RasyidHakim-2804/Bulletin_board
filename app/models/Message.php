<?php
namespace App\Models;

use App\Core\Model;

class Message extends Model
{
  
  public static function get()
  {
    $table = Model::myQuery("SELECT * FROM message ORDER BY id DESC");
    $row   = Model::myAssoc($table);
    
    Model::myClose();

    return $row;
  }

  public static function store($message)
  {
    $value  = Model::myEscapeString($message);
    $query  = "INSERT INTO message ( body ) VALUE ('$value')";
    $result = Model::myQuery($query);

    Model::myClose();

    return $result;
  }
}