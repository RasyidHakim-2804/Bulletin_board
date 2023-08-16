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
    
    $table  = $this->conn->myQuery("SELECT * FROM message ORDER BY id DESC");
    $row    = $this->conn->myAssoc($table);

    //membersihkan data untuk menghilangkan html
    array_walk($row, function ( &$data) {
      
      $data = [
        'created_on'   => strtotime($data['time']),
        'message_data' => htmlspecialchars($data['message_data']),
      ];

    });

    return $row;
    
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
      
    if ($result) $statusQuery  = 'success';

    return [ 
      'status'      => TRUE, 
      'statusQuery' => $statusQuery,
    ];
      
  }


}

