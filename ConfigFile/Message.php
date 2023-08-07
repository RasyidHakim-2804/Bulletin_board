<?php

include('Config.php');
include('validation.php');

class Message
{

  public $message;
  public $fixMessage;
  public $statusLength;
  public $statusDB;
  public $length;

  public function __construct($message)
  {
    $this->message      = $message;
    $this->fixMessage   = clean_message($this->message);
    $this->length       = strlen($this->fixMessage);
    $this->statusLength = length_validation($this->fixMessage, 200, 10);
  }


  private function add_message($input)
  {
    $query = "INSERT INTO message ( message_data ) VALUE ('$input')";
    
    $result = query($query);
  
    //mengembalikan response bila gagal
    if ($result) return 'success'; 
    
    return 'fail';
    
  }
  

  //method prosses
  public function process()
  {

    if ($this->statusLength == 'pass') {
    
      $this->statusDB = $this->add_message($this->fixMessage);
    
    }
    
    $result = [
      'lengthStatus' => $this->statusLength, 
      'length'       => $this->length, 
      'statusDB'     => $this->statusDB,
    ];
  
    return $result;
  
  }

//menampilkan data
function show_message() {

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

}