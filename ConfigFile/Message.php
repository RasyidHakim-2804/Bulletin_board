<?php

include_once('MyConnection.php');
include_once('Validation.php');

class Message
{

  private $conn;
  private $validation;
  
  public function __construct(MyConnection $conn)
  {

    $this->conn       = $conn;
    $this->validation = new Validation();
  
  }

  //menampilkan data
  public function get()
  {
    
    $table  = $this->conn->myQuery("SELECT * FROM message");
    $row    = $this->conn->myAssoc($table);
    $result = [];

    //membersihkan data untuk menghilangkan html
    foreach ($row as $data) {

      $time = strtotime($data['time']);
      $desc = htmlspecialchars($data['message_data']);

      $result[] = [
        'created_on'   => $time,
        'message_data' => $desc, 
        ];
    }

    //mengurutkan dari yang paling baru
    return array_reverse($result);
    
  }


  
  //menambah pesan
  function post(string $message): array
  {

    $fixMessage   = $this->validation->clearString($message);
    $statusLength = $this->validation->validateLength($fixMessage,10,200);

    if ($statusLength !== 'pass') {
      
      return [ 
        'status'       => FALSE,
        'statusLength' => $statusLength,
        'length'       => strlen($fixMessage),
      ];
      
    }

    $value  = $this->conn->myEscapeString($fixMessage);
    $query  = "INSERT INTO message ( message_data ) VALUE ('$value')";  
    $result = $this->conn->myQuery($query);
    
    //mengembalikan response bila gagal
    if (!$result) $statusQuery = 'fail'; 
      
    if ($result) $statusQuery = 'success';

    return [ 
      'status'      => TRUE, 
      'statusQuery' => $statusQuery,
    ];
      
  }


}

