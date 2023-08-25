<?php

namespace App\Controllers;


use App\Core\Database;
use App\Core\Helpers\Validation;

use function App\Core\Helpers\redirect;

class MessageController
{
  use Validation;

  private static $conn;
  
  //init
  private static function initialize()
  {
    self::$conn = new Database;
  }
  
  //menampilkan data
  public static function get(): array
  {
    
    self::initialize();

    $table  = self::$conn->myQuery("SELECT * FROM message ORDER BY id DESC");
    $row    = self::$conn->myAssoc($table);

    //membersihkan data untuk menghilangkan html
    array_walk($row, function ( &$value) {
      
      $value = [
        'id'   => $value['id'],
        'time' => strtotime($value['time']),
        'body' => htmlspecialchars($value['body']),
      ];

    });

    return $row;
    
  }


  
  //menambah pesan
  public static function store(): array
  {

    self::initialize();

    $message      = $_POST['message_data'];
    $response     = [];
    $fixMessage   = self::clearString($message);
    $statusLength = self::validateLength($fixMessage,10,200);

    if ($statusLength !== 'pass') {
      
      $response = [ 
        'status'       => FALSE,
        'statusLength' => $statusLength,
        'length'       => strlen($fixMessage),
      ];
      
    }

    if($statusLength === 'pass') {
      $value  = self::$conn->myEscapeString($fixMessage);
      $query  = "INSERT INTO message ( body ) VALUE ('$value')";  
      $result = self::$conn->myQuery($query);
      
      //mengembalikan response bila gagal
      if (!$result) $statusQuery = 'fail'; 
        
      if ($result) $statusQuery  = 'success';

      $response = [ 
        'status'      => TRUE, 
        'statusQuery' => $statusQuery,
      ];
    }

    
    return redirect('/');
      
  }


}

