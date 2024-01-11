<?php
namespace Database\SQL;

interface SqlQueryBuilder
{
    public function create(string $table, array $fields): SqlQueryBuilder;

    public function select(string $table, array $fields): SqlQueryBuilder;

    public function update(string $table, array $fields): SqlQueryBuilder;

    public function delete(string $table): SqlQueryBuilder;

    public function where(string $field, string $operator, string $value): SqlQueryBuilder;

    public function limit(int $start, int $offset): SqlQueryBuilder;

    public function getSQL();
}