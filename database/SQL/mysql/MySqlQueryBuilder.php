<?php

namespace Database\SQL\Mysql;

use Database\SQL\SqlQueryBuilder;

class MySqlQueryBuilder implements SqlQueryBuilder
{
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass();
    }

    protected function build(): string
    {
        $query = $this->query;
        $sql = $query->base;

        if ($query->type === 'delete' && empty($query->where)) {
            throw new \Exception("DELETE can only be used if there is WHERE");
        }
        if ($query->type === 'update' && empty($query->where)) {
            throw new \Exception("UPDATE can only be used if there is WHERE");
        }
        if (!empty($query->where)) {
            $sql .= $query->where;
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        $sql .= ";";
        return $sql;
    }

    /**
     * Build a base CREATE query.
     */
    public function create(string $table, array $fields): SqlQueryBuilder
    {
        $this->reset();

        $column = implode(", ", array_keys($fields));
        $values  = implode(", ", array_values($fields));

        $this->query->base = "INSERT INTO {$table} ({$column}) VALUES ({$values})";

        return $this;
    }

    /**
     * Build a base UPDATE query.
     */
    public function update(string $table, array $fields): SqlQueryBuilder
    {
        $this->reset();

        $set = '';
        foreach ($fields as $key => $value) {
            $set .= " {$key} = {$value}, ";
        }
        $set = rtrim($set, ', ');

        $this->query->base = "INSERT INTO {$table} SET $set";
        $this->query->type = 'update';

        return $this;
    }

    /**
     * Build a base DELETE query.
     */
    public function delete(string $table): SqlQueryBuilder
    {
        $this->reset();
        $this->query->base = "DELETE FROM {$table}";
        $this->query->type = 'delete';

        return $this;
    }

    /**
     * Build a base SELECT query.
     * @param $fields = ['column1', 'column2', ...]
     */
    public function select(string $table, string|array $fields = '*'): SQLQueryBuilder
    {
        $this->reset();

        if ($fields === '*') {
            $this->query->base = "SELECT * FROM " . $table;
        } else {
            $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        }
        $this->query->type = 'select';

        return $this;
    }

    /**
     * Add a WHERE condition.
     */
    public function where(string $field, string $operator, string $value): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }

        if (!isset($this->query->where)) {
            $this->query->where = "$field $operator '$value'";
        } else {
            $this->query->where .= "AND $field $operator '$value'";
        }

        return $this;
    }

    /**
     * Add a LIMIT constraint.
     */
    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL()
    {
        $query = $this->build();
    }
}
