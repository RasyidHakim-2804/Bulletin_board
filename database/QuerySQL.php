<?php

namespace Database;

use PDO;
use App\Helpers\HelperFunction as Helper;

abstract class QuerySQL
{
  //properti for table
  private $db;
  protected string $table;

  /**
   * public string $table; dari child class(models)
   */

  public function __construct()
  {
    $this->db = (new DB)->initialize();
  }



  private function type($value)
  {
    $type = PDO::PARAM_STR;

    if (is_int($value)) $type = PDO::PARAM_INT;

    if (is_bool($value)) $type = PDO::PARAM_BOOL;

    if (is_null($value)) $type = PDO::PARAM_NULL;

    return $type;
  }

  //CRUD method

  public function create(array $field)
  {
    $column   = array_keys($field);

    $params = ':' . implode(', :', $column);
    $keys   = implode(', ', $column);

    $query = "INSERT INTO {$this->table} ({$keys}) VALUES ({$params})";

    $stmt  = $this->db->prepare($query);

    foreach ($field as $key => $value) {
      $type = $this->type($value);
      $stmt->bindValue(":{$key}", $value, $type);
    }

    try {

      if (!$stmt->execute()) {
        throw new \Exception($stmt->errorInfo()[2]);
      }
      return true;
    } catch (\Exception $e) {

      Helper::showError(500, $e->getMessage());
      // echo $e->getMessage();
    }
  }

  /**
   * @param array $field berisi key= kolom , value= value untuk data
   * @param $id adalah nilai untuk $collumn WHERE
   * @param string $collumn adalah nama kolom untuk WHERE
   */
  public function updateFirst($id, array $field, string $collumn = 'id')
  {
    $set = '';

    foreach ($field as $key => $value) {
      $set .= $key . ' = :' . $key . ', ';
    }
    $set = rtrim($set, ', ');


    $query = "UPDATE {$this->table} SET $set WHERE $collumn = :id";
    $stmt  = $this->db->prepare($query);

    $stmt->bindValue(':id', $id, $this->type($id));

    foreach ($field as $key => $value) {
      $type = $this->type($value);
      $stmt->bindValue(":{$key}", $value, $type);
    }

    try {
      if (!$stmt->execute()) {
        throw new \Exception($stmt->errorInfo()[2]);
      }
      return true;
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }

  /**
   * fetch all data
   */
  public function getAll(string $sort = "ASC")
  {

    $query = "SELECT * FROM {$this->table} ORDER BY id {$sort}";
    $stmt  = $this->db->query($query);

    try {

      if (!$stmt->execute()) {
        throw new \Exception($stmt->errorInfo()[2]);
      }
      return $stmt->fetchAll();
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }

  /**
   * fetch first data
   */
  public function findFirst($value, $collumn = 'id')
  {
    $query = "SELECT * FROM {$this->table} WHERE {$collumn} = :value LIMIT 1";
    $stmt  = $this->db->prepare($query);
    $stmt->bindParam(':value', $value);

    try {
      if (!$stmt->execute()) {
        throw new \Exception($stmt->errorInfo()[2]);
      }

      $result = $stmt->fetchAll();

      if (empty($result)) {
        return null;
      }

      return $result[0];
    
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }

  public function deleteFirst($value, $collumn = 'id')
  {
    $query = "DELETE FROM {$this->table} WHERE {$collumn} = :value LIMIT 1";
    $stmt  = $this->db->prepare($query);
    $stmt->bindParam(':value', $value);

    try {
      if (!$stmt->execute()) {
        throw new \Exception($stmt->errorInfo()[2]);
      }
      return true;
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }
}
