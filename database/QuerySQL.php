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

      return $stmt->execute();
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
    try {
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

      return $stmt->execute();
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }



  public function getAll(string $sort = "ASC")
  {
    try {

      $query = "SELECT * FROM {$this->table} ORDER BY id {$sort}";

      return $this->db->query($query)->fetchAll();
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }

  public function findFirst($value, $collumn = 'id')
  {
    try {
      $query = "SELECT * FROM {$this->table} WHERE {$collumn} = :value LIMIT 1";
      $stmt  = $this->db->prepare($query);
      $stmt->bindParam(':value', $value);
      $stmt->execute();

      return $stmt->fetchAll()[0];
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }

  public function deleteFirst($value, $collumn = 'id')
  {
    try {
      $query = "DELETE FROM {$this->table} WHERE {$collumn} = :value LIMIT 1";
      $stmt  = $this->db->prepare($query);
      $stmt->bindParam(':value', $value);

      return $stmt->execute();
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
    }
  }
}
