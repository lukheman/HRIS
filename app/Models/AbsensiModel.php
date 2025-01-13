<?php

namespace App\Models;

use App\Core\Model;


class AbsensiModel extends Model {

  protected $table = 'tb_model';

  public function all() {
    $query = "SELECT a.id, a.karyawan_id, a.tanggal, a.jam_masuk, a.jam_keluar, a.lembur, a.status,
             k.nama, k.nik, k.jabatan
              FROM tb_absensi a
              JOIN tb_karyawan k ON a.karyawan_id = k.id";
    return $this->query($query)->fetchAll();
  }

}
