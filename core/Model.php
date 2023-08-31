<?php
namespace Core;

use \PDO;

class Model
{

  public string  $table;
  public array   $column;
  private PDO    $db;

  public function __construct()
  {
    $db = new Database();

    $this->db     = $db->getDB();
  }

  public function getAll(string $sort = "ASC")
  {
    $query = "SELECT * FROM {$this->table} ORDER BY id {$sort}";

    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }


  public function store(array $data)
  {
    array_walk($data, function( &$value, &$key){
      
      //jika key sesuai dengan properti table
      if(in_array($key, $this->column)) {

        try {  
          $sql  = "INSERT INTO {$this->table} ({$key}) VALUE ( :value)";
          $stmt = $this->db->prepare($sql);
          $stmt->bindParam(":value", $value);
          $stmt->execute();
            
        } catch (\PDOException $e) {

          return "fail, because: {$e}";
        
        }
      }
    });

    return 'success';
  }

  
}