<?php

namespace App\Models;

use App\Core\Model;

class KaryawanModel extends Model
{
    protected $table = 'tb_karyawan';

    public function all()
    {
        $sql = "SELECT
        k.id as id_karyawan,
        nama,
        nik,
        tanggal_lahir,
        alamat,
        j.id as id_jabatan,
        j.jabatan,
        j.gaji
        FROM {$this->table} k JOIN tb_jabatan j on k.id_jabatan = j.id";
        return $this->query($sql)->fetchAll();
    }

    public function findById($id)
    {
      $sql = "SELECT
        k.id AS id_karyawan,
        k.nama,
        k.nik,
        k.tanggal_lahir,
        k.alamat,
        k.gaji_lembur,
        j.jabatan,
        j.gaji
        FROM {$this->table} k
        JOIN tb_jabatan j ON k.id_jabatan = j.id
        WHERE k.id = ?";
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
