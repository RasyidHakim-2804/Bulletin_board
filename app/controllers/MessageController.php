<?php
namespace App\Controllers;


use App\Models\Message;
use App\Helpers\MyString;
use App\Helpers\HelperFunction as Helper;

class MessageController
{
  public function index($response = null)
  {
    $row    = (new Message)->getAll('DESC');

    //membersihkan data untuk menonaktifkan html tag pada client
    array_walk($row, function ( &$value) {
      $time = strtotime($value['time']);
      $time = date("Y-m-d  h:i:sa", $time);
      
      $value = [
        'id'   => $value['id'],
        'time' => $time,
        'body' => htmlspecialchars($value['body']),
      ];
    });

    if(isset($response)) return Helper::view('home', ['row' => $row, 'response' => $response]);

    return Helper::view('home', ['row' => $row]); 
  }
  
  //menambah pesan
  public function store()
  {
    $message      = Helper::getPostVariable('message_data')?? '';
    $response     = [];
    $fixMessage   = MyString::sanitizeSpaces($message);
    $statusLength = MyString::validateLength($fixMessage,10,200);

    if ($statusLength !== 'pass') {
      
      $response = [ 
        'no-valid'     => [
          'statusLength' => $statusLength,
          'length'       => strlen($fixMessage),
        ]        
      ];      
    }

    if($statusLength === 'pass') {
      
      $response = (new Message)->create(['body' => $fixMessage]);

    }

    return $this->index($response);   
  }
}

