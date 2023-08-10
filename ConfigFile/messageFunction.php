<?php

include('config.php');
include('validation.php');



  //menampilkan data
function get_messages() 
{

  $table  = query("SELECT * FROM message");
  $row    = assoc($table);
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
function add_message($message)
{

  $fixMessage   = string_cleaner($message);
  $statusLength = length_validation($fixMessage,10,200);

  if ($statusLength !== 'pass') {
    
    return [ 
      'status'       => FALSE,
      'statusLength' => $statusLength,
      'length'       => strlen($fixMessage),
    ];
    
  }

  $value  = escape_string($fixMessage);
  $query  = "INSERT INTO message ( message_data ) VALUE ('$value')";  
  $result = query($query);
  
  //mengembalikan response bila gagal
  if (!$result) $statusQuery = 'fail'; 
    
  if ($result) $statusQuery = 'success';

  return [ 
    'status'      => TRUE, 
    'statusQuery' => $statusQuery,
  ];
    
}


