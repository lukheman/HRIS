<?php

namespace App\Models;


use App\Core\Model;

class KaryawanModel extends Model {

  protected $table = 'tb_karyawan';

  public function findById($id) {
    $sql = "SELECT * FROM {$this->table} WHERE id = ?";
    return $this->query($sql, [$id])->fetch();
  }

}
