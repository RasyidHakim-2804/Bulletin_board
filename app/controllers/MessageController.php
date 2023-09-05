<?php
namespace App\Controllers;


use App\Models\Message;
use App\Helpers\Validation;

use function App\Helpers\get_post_variable;
use function App\Helpers\redirect;
use function App\Helpers\set_flash_message;
use function App\Helpers\view;

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
    $message      = get_post_variable('message_data')?? '';
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
      
      $statusQuery = (new Message)->create(['body' => $fixMessage]);

      $response = [ 
          'valid'       => true, 
          'statusQuery' => $statusQuery,
      ];
    }

    set_flash_message('response', $response);
    return redirect('/home');   
  }
}

