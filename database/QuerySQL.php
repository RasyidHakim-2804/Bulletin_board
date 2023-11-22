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


  /** 
   * menyiapkan nilai2 query
   * contoh $field =['body' => 'ini badan', 'tangan' => 'ini tangan', 'kaki' => 'ini kaki']
   * maka hasil returnnya adalah
   * $keys   = 'body, tangan, kaki';
   * $params = ':body, :tangan, :kaki';
   */
  private function setPrepare(array $field)
  {
    $column   = array_keys($field);

    $params = ':' . implode(', :', $column);
    $keys   = implode(', ', $column);

    return [$keys, $params];
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
    try {

      [$keys, $params] = $this->setPrepare($field);

      $query = "INSERT INTO {$this->table} ({$keys}) VALUES ({$params})";

      $stmt  = $this->db->prepare($query);

      foreach ($field as $key => $value) {
        $type = $this->type($value);
        $stmt->bindValue(":{$key}", $value, $type);
      }

      return $stmt->execute();
    } catch (\Exception $e) {
      Helper::showError(500, $e->getMessage());
      // echo $e->getMessage();
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
}
