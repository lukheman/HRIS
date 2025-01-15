<?php

namespace App\Models;

use App\Core\Model;


class AbsensiModel extends Model {

  protected $table = 'tb_absensi';

  public function all() {
    $query = "SELECT a.id, a.karyawan_id, a.tanggal, a.jam_masuk, a.jam_keluar, a.lembur, a.status,
             k.nama, k.nik, k.jabatan
              FROM tb_absensi a
              JOIN tb_karyawan k ON a.karyawan_id = k.id";
    return $this->query($query)->fetchAll();
  }

  public function findByTanggal($tanggal) {
    $sql = "SELECT * FROM {$this->table} JOIN tb_karyawan on tb_absensi.karyawan_id = tb_karyawan.id WHERE tanggal = ?";

    return $this->query($sql, [$tanggal])->fetchAll();
  }

  public function findByBulan($bulan) {

    $sql = "SELECT * FROM {$this->table} JOIN tb_karyawan on tb_absensi.karyawan_id = tb_karyawan.id WHERE DATE_FORMAT(tanggal, '%Y-%m') = ?";

    return $this->query($sql, [$bulan])->fetchAll();
  }

  public function absensiBulananKaryawan($id, $periode) {

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

}
