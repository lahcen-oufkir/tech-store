<?php

namespace App\Core;

/**
 * Base model providing common CRUD operations.
 * Child classes must set $table (and optionally $primaryKey).
 */
abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function all()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC");
    }

    public function find($id)
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1",
            [$id]
        );
    }

    /** Fetch rows matching a simple WHERE condition. */
    public function where($column, $value, $operator = '=')
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE {$column} {$operator} ? ORDER BY {$this->primaryKey} DESC",
            [$value]
        );
    }

    /** Fetch a single row matching a condition. */
    public function firstWhere($column, $value)
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1",
            [$value]
        );
    }

    public function count()
    {
        return (int) $this->db->value("SELECT COUNT(*) FROM {$this->table}");
    }

    /** Insert an associative array, returns the new id. */
    public function create($data)
    {
        $columns     = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $this->db->run(
            "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})",
            array_values($data)
        );

        return $this->db->lastInsertId();
    }

    /** Update a row by primary key, returns affected rows. */
    public function update($id, $data)
    {
        $sets = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));

        $stmt = $this->db->run(
            "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?",
            array_merge(array_values($data), [$id])
        );

        return $stmt->rowCount();
    }

    /** Delete a row by primary key. */
    public function delete($id)
    {
        return $this->db->run(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        );
    }
}
