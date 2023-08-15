<?php

class MyConnection extends mysqli
{
  private const SERVER   = "localhost";
  private const USER     = "root";
  private const PASSWORD = "rootRoot";
  private const DATABASE = "bulletin_board";
  private $connection;

  public function __construct()
  {
    $this->connection = new mysqli(self::SERVER, self::USER, self::PASSWORD, self::DATABASE);
    
    if ($this->connection->connect_errno) {
    
      trigger_error('Failed to connect to MySQL:' . ' ' . $this->connection->connect_error);      
    
    }
    
  }


  //function query, untuk menjalankan syntax SQL
  public function myQuery($query) 
  {
    $result = $this->connection->query($query);
    
    //mengecek adanya eror pada syntax
    if (!$result) echo 'Error description:' . ' ' . $this->connection->error;
    
    if ($result) return $result;

  }

  public function myAssoc($table)
  {
    $data = [];

    while ($row = $table->fetch_assoc()) {
      
      $data[] = $row; 

    }

    return $data;

  }


  public function myEscapeString(string $input)
  {

    return $this->connection->real_escape_string($input);
  
  }


  public function myClose()
  {
    $this->connection->close();
  }


}

