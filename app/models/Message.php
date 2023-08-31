<?php
namespace App\Models;

//use App\Core\Database;
use Core\Model;

class Message extends Model
{

  public string $table    = 'message';
  public array $column    = ['id', 'body', 'time'];

}