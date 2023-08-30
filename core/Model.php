<?php
namespace Core;

class Model
{

  protected $table;
  private   $db;

  public function __construct(string $table)
  {
    $db = new Database();

    $this->db    = $db->getDB();
    $this->table = $table;
  }

  public function getAll(string $orderBy = "DESC")
  {
    $query = "SELECT * FROM {$this->table} ORDER BY id {$orderBy}";

    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }
  
}