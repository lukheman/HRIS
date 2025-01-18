<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Method dasar untuk query
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Mengambil semua record
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->fetchAll();
    }

    // Mengambil satu record berdasarkan ID
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->fetch();
    }

    // Menyimpan record baru
    public function create($data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";

        $this->query($sql, array_values($data));
        return $this->db->lastInsertId();
    }

    // Mengupdate record
    public function update($id, $data)
    {
        $fields = implode('=?, ', array_keys($data)) . '=?';
        $sql = "UPDATE {$this->table} SET $fields WHERE id = ?";

        $values = array_values($data);
        $values[] = $id;

        return $this->query($sql, $values)->rowCount();
    }

    // Menghapus record
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->rowCount();
    }
}
