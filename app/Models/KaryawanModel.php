<?php

namespace App\Models;

use App\Core\Model;

class KaryawanModel extends Model
{
    protected $table = 'tb_karyawan';

    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->fetch();
    }

    public function findByNik($nik)
    {
        $sql = "SELECT * FROM {$this->table} WHERE nik = ?";
        return $this->query($sql, [$nik])->fetch();
    }

    public function findByNama($nama)
    {
        $sql = "SELECT * FROM {$this->table} WHERE nama LIKE ?";
        $search = "%{$nama}%";
        return $this->query($sql, [$search])->fetchAll();
    }

    public function count()
    {
        $sql = "SELECT count(*) as jumlah FROM {$this->table}";

        return $this->query($sql)->fetch();
    }



}
