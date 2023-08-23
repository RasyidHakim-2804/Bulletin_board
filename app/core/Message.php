<?php

namespace App\Core;

class Message
{

  private $conn;
  private $validation;
  
  public function __construct()
  {

    $this->conn       = new Database;
    $this->validation = new Validation;
  
  }


  //menampilkan data
  public function get()
  {
    
    $table  = $this->conn->myQuery("SELECT * FROM message ORDER BY id DESC");
    $row    = $this->conn->myAssoc($table);

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

  public function paginate()
  {
    
  }


  
  //menambah pesan
  public function post(string $message): array
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
    $query  = "INSERT INTO message ( body ) VALUE ('$value')";  
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

