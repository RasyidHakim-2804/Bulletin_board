<?php
namespace Core;

use \PDO;

class Model
{

  public string  $table;
  public array   $attributes;
  private PDO    $db;

  public function __construct(string $table, array $attributes)
  {
    $db = new Database();

    $this->db         = $db->getDB();
    $this->table      = $table;
    $this->attributes = $attributes;
  }

  public function getAll(string $orderBy = "DESC")
  {
    $query = "SELECT * FROM {$this->table} ORDER BY id {$orderBy}";

    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }


  public function store(array $data)
  {
    array_walk($data, function( &$value, &$key){
      
      //jika key sesuai dengan properti table
      if(in_array($key, $this->attributes)) {

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