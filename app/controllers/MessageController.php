<?php
namespace App\Controllers;


use App\Models\Message;
use App\Helpers\Validation;

use function App\Helpers\get_post_variable;
use function App\Helpers\view;

class MessageController
{
  use Validation;
  
  //menampilkan data
  public function get($response = null)
  {
    $row    = (new Message)->getAll('DESC');

    //membersihkan data untuk menghilangkan html
    array_walk($row, function ( &$value) {
      $time = strtotime($value['time']);
      $time = date("Y-m-d  h:i:sa", $time);
      
      $value = [
        'id'   => $value['id'],
        'time' => $time,
        'body' => htmlspecialchars($value['body']),
      ];
    });

    if(isset($response)) return view('home', ['row' => $row, 'response' => $response]);

    return view('home', ['row' => $row]); 
  }
  
  //menambah pesan
  public function store()
  {
    $message      = get_post_variable('message_data')?? '';
    $response     = [];
    $fixMessage   = $this->clearString($message);
    $statusLength = $this->validateLength($fixMessage,10,200);

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

    return $this->get($response);   
  }
}

