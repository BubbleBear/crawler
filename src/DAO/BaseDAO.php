<?php

namespace Vatel\DAO;

abstract class BaseDAO
{
    private $conn;

    public final function __construct($container)
    {
        $this->conn = $container['DBConnection'];
        $this->boot();
    }

    public function insert($fields)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(', ', array_keys($fields)) . ') VALUES ('
            . implode(', ', array_fill(0, count($fields), '?')) . ')';

        return $this->conn->exec($sql, array_values($fields))->rowCount();
    }

    public function delete($conditions)
    {
        $sql = 'DELETE FROM ' . $this->table . (empty($container) ? '' : ' WHERE ' . implode(' = ? AND ', array_keys($conditions)) . ' = ?');

        return $this->conn->exec($sql, array_values($conditions))->rowCount();
    }

    public function update($fields, $conditions)
    {
        $sql = 'UPDATE ' . $this->table . ' SET ' . implode(' = ? , ', array_keys($fields)) . ' = ? WHERE '
            . implode(' = ? AND ', array_keys($conditions)) . ' = ?';

        return $this->conn->exec($sql, array_merge(array_values($fields), array_values($conditions)))->rowCount();
    }

    public function findEquals($conditions = array(), $fields = array())
    {
        $sql = 'SELECT ' . (empty($fields) ? '*' : implode(', ', $fields)) . ' FROM ' . $this->table . (empty($conditions) ? '' : ' WHERE '
            . implode(' = ? AND ', array_keys($conditions)) . ' = ?');

        return $this->conn->exec($sql, array_values($conditions))->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function boot()
    {
        ;
    }
}