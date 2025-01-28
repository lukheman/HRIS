<?php

namespace App\Models;

use App\Core\Model;

class AbsensiModel extends Model
{
    protected $table = 'tb_absensi';

    public function all()
    {
        $query = "SELECT a.id, a.karyawan_id, a.tanggal, a.jam_masuk, a.jam_keluar, a.lembur, a.status,
             k.nama, k.nik, k.jabatan
              FROM tb_absensi a
              JOIN tb_karyawan k ON a.karyawan_id = k.id";
        return $this->query($query)->fetchAll();
    }

    public function findByTanggal($tanggal)
    {
        $sql = "SELECT a.id AS id_absensi, a.*, k.* FROM {$this->table} a JOIN tb_karyawan k on a.karyawan_id = k.id WHERE a.tanggal = ?";

        return $this->query($sql, [$tanggal])->fetchAll();
    }

    public function today() {
      $tanggal = date('Y-m-d');

      return $this->findByTanggal($tanggal);
    }

    public function findByBulan($bulan)
    {

        $sql = "SELECT a.id AS id_absensi, a.*, k.* FROM {$this->table} a JOIN tb_karyawan k on a.karyawan_id = k.id WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = ?";

        return $this->query($sql, [$bulan])->fetchAll();
    }

    public function absensiBulananKaryawan($id, $periode)
    {

        // DATE_FORMAT(a.tanggal, '%d') AS tanggal,
        $sql = "SELECT
      k.nama AS nama_karyawan,
      k.nik,
      a.id,
      a.tanggal,
      a.jam_masuk,
      a.jam_keluar,
      a.lembur,
      a.status
  FROM
      tb_absensi a
  JOIN
      tb_karyawan k ON a.karyawan_id = k.id
  WHERE
      k.id = ? -- Ganti dengan ID karyawan yang diinginkan
      AND DATE_FORMAT(a.tanggal, '%Y-%m') = ?; -- Ganti dengan format 'YYYY-MM' untuk bulan tertentu";

        return $this->query($sql, [$id, $periode])->fetchAll();

    }

    public function isKaryawanAbsen($id, $tanggal)
    {

        $sql = "SELECT * FROM {$this->table} WHERE karyawan_id = ? AND tanggal = ?";
        return $this->query($sql, [$id, $tanggal])->fetch();

    }

}
