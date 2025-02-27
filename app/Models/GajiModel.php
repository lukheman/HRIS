<?php

namespace App\Models;

use App\Core\Model;

use PDO;

class GajiModel extends Model
{
    protected $table = 'tb_gaji';

    public function allComplete()
    {
        $sql = "SELECT
      g.id as id_gaji,
      g.periode,
      g.gaji_pokok,
      g.gaji_lembur,
      g.gaji_total,
      g.total_lembur,
      g.status,
      k.nama
      FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id";

        return $this->query($sql)->fetchAll();
    }

    public function findBetweenPeriode($start, $end)
    {
        $sql = "SELECT
        g.id as id_gaji,
        g.periode,
        g.gaji_pokok,
        g.gaji_lembur,
        g.gaji_total,
        g.total_lembur,
        g.status,
        k.nama
        FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id
        WHERE g.periode BETWEEN ? AND ? ORDER BY g.periode";

        return $this->query($sql, [$start, $end])->fetchAll();
    }

    public function findKaryawanBetweenPeriode($id, $start, $end)
    {
        $sql = "SELECT
        g.id as id_gaji,
        g.periode,
        g.gaji_pokok,
        g.gaji_lembur,
        g.gaji_total,
        g.total_lembur,
        g.status,
        k.nama
        FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id
        WHERE g.karyawan_id = ? AND g.periode BETWEEN ? AND ? ORDER BY g.periode";

        return $this->query($sql, [$id, $start, $end])->fetchAll();
    }

    public function findByPeriode($periode)
    {
        $sql = "SELECT
      g.id as gaji_id,
      g.periode,
      g.gaji_pokok,
      g.gaji_lembur,
      g.gaji_total,
      g.total_lembur,
      g.status,
      k.nama,
      k.jabatan
      FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id WHERE g.periode = ?";
        return $this->query($sql, [$periode])->fetchAll();
    }

    public function findById($id)
    {
      $sql = "SELECT * FROM {$this->table}
        JOIN tb_karyawan k ON k.id = {$this->table}.karyawan_id
        JOIN tb_jabatan j ON k.id_jabatan = j.id
        WHERE {$this->table}.id = ?";

        return $this->query($sql, [$id])->fetch();
    }

    public function findByKaryawanId($id)
    {
        $sql = "SELECT g.id AS id_gaji, g.* FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id where g.karyawan_id = ?";
        return $this->query($sql, [$id])->fetchAll();
    }

    public function findByKaryawanIdStatus($id, $status)
    {
        $sql = "SELECT g.id AS gaji_id, g.* FROM {$this->table} g JOIN tb_karyawan k on k.id = g.karyawan_id where g.karyawan_id = ? AND g.status = ?";
        return $this->query($sql, [$id, $status])->fetchAll();
    }


    public function existKaryawanPeriode($id, $periode)
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE karyawan_id = ? AND periode = ?";

        return $this->query($sql, [$id, $periode])->fetch();

    }

    public function totalGaji($periode)
    {
        // mengembalikan total gaji pada periode tertentu
        $sql = "SELECT sum(gaji_total) as total from {$this->table} where periode = ?";
        return $this->query($sql, [$periode])->fetch()->total;
    }



}
