<?php
namespace App\Controllers;


use App\Models\Message;
use App\Helpers\Validation;

use function App\Helpers\redirect;
use function App\Helpers\view;
use function App\Helpers\setSession;

class MessageController
{
  use Validation;
  
  //menampilkan data
  public static function get()
  {
    
    $row    = (new Message)->getAll('DESC');

    //membersihkan data untuk menghilangkan html
    array_walk($row, function ( &$value) {
      
      $value = [
        'id'   => $value['id'],
        'time' => strtotime($value['time']),
        'body' => htmlspecialchars($value['body']),
      ];

    });

    return view('home', ['row' => $row]);
    
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
      
      $statusQuery = (new Message)->store(['body' => $fixMessage]);

      $response = [ 
          'valid'       => true, 
          'statusQuery' => $statusQuery,
      ];
    }

    setSession('response', $response);
    return redirect('/home');
      
  }


}

