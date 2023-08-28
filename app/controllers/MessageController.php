<?php

namespace App\Controllers;


use App\Models\Message;
use App\Core\Helpers\Validation;

use function App\Core\Helpers\redirect;

class MessageController
{
  use Validation;
  
  //menampilkan data
  public static function get(): array
  {
    
    $row    = Message::get();

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
  public static function store()
  {

    $message      = $_POST['message_data']?? '';
    $response     = [];
    $fixMessage   = self::clearString($message);
    $statusLength = self::validateLength($fixMessage,10,200);

    if ($statusLength !== 'pass') {
      
      $response = [ 
        'valid'        => false,
        'statusLength' => $statusLength,
        'length'       => strlen($fixMessage),
      ];
      
    }

    if($statusLength === 'pass') {
  
      $result = Message::store($fixMessage);
      
      //mengembalikan response bila gagal
      if (!$result) $statusQuery = 'fail'; 
      if ($result)  $statusQuery = 'success';

      $response = [ 
          'valid'       => true, 
          'statusQuery' => $statusQuery,
      ];
    }

    
    return redirect('/home', $response);
      
  }


}

