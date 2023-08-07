<?php
include('function.php');


function proses($data)
{
  
  $cleanData        = clean_message($data);
  $length           = strlen($cleanData);
  $lengthValidation = length_validation($cleanData, 200, 10);
  $statusDB         = '';

  if ($lengthValidation == 'pass') {
    
    $statusDB = add_data('message', 'message_data', $cleanData);
  
  }
  
  $result = [
    'lengthStatus' => $lengthValidation, 
    'length'       => $length, 
    'statusDB'     => $statusDB,
  ];

  return $result;


}