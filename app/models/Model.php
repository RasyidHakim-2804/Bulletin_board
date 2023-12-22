<?php
namespace App\Models;

use Database\QuerySQL;

class Model
{
    protected string $table;
    protected QuerySQL $query;

    public function __construct()
    {
        $this->query = new QuerySQL($this->table);
    }

    public function create($fields)
    {
        return $this->query->create($fields);
    }

    public function update(array $primaryKey, array $field)
    {
        return $this->query->update($primaryKey, $field);
    }

    public function getAll(string $sort = "ASC")
    {
        return $this->query->getAll($sort);
    }

    public function findFirst($value, $collumn = 'id')
    {
        return $this->query->findFirst($value, $collumn);
    }

    public function delete($value, $collumn = 'id')
    {
        return $this->query->deleteFirst($value, $collumn);
    }

}