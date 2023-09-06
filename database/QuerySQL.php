<?php
namespace Database;

use PDO;

abstract class QuerySQL
{
  //properti for table
  protected $db;

  /**
   * public string $table; dari child class(models)
   */
  
  public function __construct()
  {
    $this->db = (new DB)->initialize();
  }


  //menyiapkan nilai2 query 
  public function setPrepare(array $field)
  {
    $column   = array_keys($field);

    $params = ':' . implode(', :', $column);
    $keys   = implode(', ', $column);

    return [$keys, $params];
  }
  
  public function bind($stmt, $key, $value)
  {
    $type = PDO::PARAM_STR;

    if(is_int($value)) $type = PDO::PARAM_INT;

    if(is_bool($value)) $type = PDO::PARAM_BOOL;

    if(is_null($value)) $type = PDO::PARAM_NULL;

    $stmt->bindValue(":{$key}", $value, $type);

  }

  //CRUD method

  public function create(array $field)
  {
    [$keys, $params] = $this->setPrepare($field);

    $query = "INSERT INTO {$this->table} ({$keys}) VALUES ({$params})";

    $stmt  = $this->db->prepare($query);

    foreach ($field as $key => $value) {
      $this->bind($stmt, $key, $value);
    }

    return $stmt->execute();
  }

  
  public function getAll(string $sort = "ASC")
  {
    $query = "SELECT * FROM {$this->table} ORDER BY id {$sort}";

    return $this->db->query($query)->fetchAll();
  }

}