<?php
namespace Database;

use PDO;
use PDOException;

use function App\Helpers\set_session;

abstract class QuerySQL
{
  //properti for table
  protected $db;
  public string $table;
  public array $column;
  
  //properti for prepared query
  protected $query;
  protected $keys;
  protected $param;
  protected $values;
  protected $stmt;

  public function __construct()
  {
    $this->db = DB::initialize();
  }


  //menyiapkan nilai2 query 
  public function setPrepare(array $data)
  {
    $data   = array_keys($data);

    $param = ':' . implode(', :', $data);
    $keys  = implode(', ', $data);

    $this->keys  = $keys;
    $this->param = $param;
  }
  
  public function bind($key, $value)
  {
    $type = PDO::PARAM_STR;

    if(is_int($value)) $type = PDO::PARAM_INT;

    if(is_bool($value)) $type = PDO::PARAM_BOOL;

    if(is_null($value)) $type = PDO::PARAM_NULL;

    $this->stmt->bindValue(":{$key}", $value, $type);

  }

  private function cleanPrepare()
  {
    $this->query  = null;
    $this->keys   = null;
    $this->param  = null;
    $this->values = null;
    $this->stmt   = null;
  }

  public function execute()
  {
    $result =TRUE;
    try {
      $this->stmt->execute();
    } catch (PDOException $e) {
      set_session('error', $e->getMessage());
      $result = FALSE;
    }

    $this->cleanPrepare();

    return $result;
    
  }

  //CRUD method

  public function create(array $data)
  {
    $this->setPrepare($data);

    $this->query = "INSERT INTO {$this->table} ({$this->keys}) VALUES ({$this->param})";

    $this->stmt = $this->db->prepare($this->query);

    foreach ($data as $key => $value) {
      $this->bind($key, $value);
    }

    return $this->execute();
  }

  
  public function getAll(string $sort = "ASC")
  {
    $query = "SELECT * FROM {$this->table} ORDER BY id {$sort}";

    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }

}