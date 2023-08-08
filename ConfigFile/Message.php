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
  public $response;

  public function __construct(string $message)
  {

    $this->message      = $message;
    $this->fixMessage   = clean_message($this->message);
    $this->length       = strlen($this->fixMessage);
    $this->statusLength = length_validation($this->fixMessage, 200, 10);
    $this->response     = $this->process();

  }


  private function add_message($input)
  {
    $query = "INSERT INTO message ( message_data ) VALUE ('$input')";
    
    $result = query($query);
  
    //mengembalikan response bila gagal
    if (!$result) return 'fail'; 
    
    return 'success';
    
  }
  

  //method prosses
  private function process()
  {

    if ($this->statusLength == 'pass') {
    
      $this->statusDB = $this->add_message($this->fixMessage);

      return TRUE;
    
    }
    
    return FALSE;
  
  }

  //menampilkan data
  public static function get_message() 
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

}