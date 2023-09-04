<?php
namespace Core;

use Database\QuerySQL;

class Model extends QuerySQL
{
  public string $table;
  public array $column;
}