<?php

namespace App\Models;

use App\Core\Model;

class PengaturanModel extends Model
{
    protected $table = 'tb_pengaturan';

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->fetch();
    }

    public function jam_masuk()
    {
        $sql = "SELECT jam_masuk from {$this->table}";
        return $this->query($sql)->fetch()->jam_masuk;
    }

    public function jam_keluar()
    {
        $sql = "SELECT jam_keluar from {$this->table}";
        return $this->query($sql)->fetch()->jam_keluar;
    }

    public function latitude()
    {
        $sql = "SELECT latitude from {$this->table}";
        return $this->query($sql)->fetch()->latitude;
    }

    public function longitude()
    {
        $sql = "SELECT longitude from {$this->table}";
        return $this->query($sql)->fetch()->longitude;
    }

    public function gaji_lembur()
    {
        $sql = "SELECT gaji_lembur from {$this->table}";
        return $this->query($sql)->fetch()->gaji_lembur;
    }

    public function radius_maksimal()
    {
        $sql = "SELECT radius_maksimal from {$this->table}";
        return $this->query($sql)->fetch()->radius_maksimal;
    }


    public function updateData($data)
    {


        // Membuat string field untuk SET
        $fields = implode('=?, ', array_keys($data)) . '=?';

        // Menyusun query UPDATE
        $sql = "UPDATE {$this->table} SET $fields";

        // Menjalankan query dengan nilai yang diberikan
        $values = array_values($data);

        return $this->query($sql, $values)->rowCount();
    }

}
