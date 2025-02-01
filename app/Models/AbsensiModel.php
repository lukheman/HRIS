<?php

namespace App\Models;

use App\Core\Model;

class AbsensiModel extends Model
{
    protected $table = 'tb_absensi';

    public function all()
    {
        $query = "SELECT a.id as id_absensi, a.karyawan_id, a.tanggal, a.jam_masuk, a.jam_keluar, a.lembur, a.status,
             k.nama, k.nik, k.jabatan
              FROM tb_absensi a
              JOIN tb_karyawan k ON a.karyawan_id = k.id";
        return $this->query($query)->fetchAll();
    }

    public function findByTanggal($tanggal)
    {
        $sql = "SELECT a.id AS id_absensi, a.*, k.* FROM {$this->table} a JOIN tb_karyawan k on a.karyawan_id = k.id WHERE a.tanggal = ? ORDER BY a.karyawan_id";

        return $this->query($sql, [$tanggal])->fetchAll();
    }

    public function today()
    {
        $tanggal = date('Y-m-d');

        return $this->findByTanggal($tanggal);
    }

    public function findByBulan($bulan)
    {

        $sql = "SELECT a.id AS id_absensi, a.*, k.* FROM {$this->table} a JOIN tb_karyawan k on a.karyawan_id = k.id WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = ? ORDER BY a.karyawan_id";

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

    public function absensiKaryawanOne($id, $start_date, $end_date)
    {
        $sql = "SELECT
      k.nama as nama_karyawan,
      k.nik,
      a.id,
      a.tanggal,
      a.jam_masuk,
      a.jam_keluar,
      a.lembur,
      a.status
        FROM {$this->table} a
        JOIN tb_karyawan k ON a.karyawan_id = k.id
        WHERE k.id = ?
        AND a.tanggal BETWEEN ? and ?
        ORDER BY a.karyawan_id ASC;";
        return $this->query($sql, [$id, $start_date, $end_date])->fetchAll();
    }

    public function absensiKaryawanAll($start_date, $end_date)
    {
        $sql = "SELECT
      k.nama as nama_karyawan,
      k.nik,
      a.id,
      a.tanggal,
      a.jam_masuk,
      a.jam_keluar,
      a.lembur,
      a.status
        FROM {$this->table} a
        JOIN tb_karyawan k ON a.karyawan_id = k.id
        AND a.tanggal BETWEEN ? and ?
        ORDER BY a.karyawan_id ASC;";
        return $this->query($sql, [$start_date, $end_date])->fetchAll();
    }

    public function isKaryawanAbsen($id, $tanggal)
    {

        $sql = "SELECT * FROM {$this->table} WHERE karyawan_id = ? AND tanggal = ?";
        return $this->query($sql, [$id, $tanggal])->fetch();

    }

    public function findByIdKaryawan($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE karyawan_id = ?";
        return $this->query($sql, [$id])->fetchAll();
    }

    public function calculateTotalLemburMonths($id)
    {
        // fungsi untuk menghitung total lembur tiap bulan
        $sql = "
      SELECT
        DATE_FORMAT(tanggal, '%Y-%m') AS periode,  -- Mengambil tahun dan bulan
        SUM(lembur) AS total_lembur              -- Menghitung total lembur
      FROM {$this->table}
      WHERE karyawan_id = ?                        -- Filter berdasarkan karyawan_id
      GROUP BY DATE_FORMAT(tanggal, '%Y-%m')       -- Kelompokkan berdasarkan bulan
      ORDER BY periode ASC;                          -- Urutkan berdasarkan bulan
      ";
        return $this->query($sql, [$id])->fetchAll();
    }

    public function getAbsensiMonth($periode)
    {
        $sql = "
SELECT
    k.nama AS nama_karyawan,
    k.id AS id_karyawan,
    GROUP_CONCAT(DATE_FORMAT(a.tanggal, '%d') ORDER BY a.tanggal ASC SEPARATOR ', ') AS tanggal_hadir,
    GROUP_CONCAT(
        CASE
            WHEN a.status = 'Hadir' THEN DATE_FORMAT(a.tanggal, '%d')
            ELSE NULL
        END
        ORDER BY a.tanggal ASC SEPARATOR ', '
    ) AS tanggal_hadir,
    GROUP_CONCAT(
        CASE
            WHEN a.status = 'Alpha' THEN DATE_FORMAT(a.tanggal, '%d')
            ELSE NULL
        END
        ORDER BY a.tanggal ASC SEPARATOR ', '
    ) AS tanggal_alpha
FROM
    tb_absensi a
JOIN
    tb_karyawan k ON a.karyawan_id = k.id
WHERE
    DATE_FORMAT(a.tanggal, '%Y-%m') = ?
GROUP BY
    k.id;
";

        return $this->query($sql, [$periode])->fetchAll();

    }

    public function getAbsensiMonthByIdKaryawan($id_karyawan, $periode)
    {
        $sql = "
SELECT
    GROUP_CONCAT(DATE_FORMAT(a.tanggal, '%d') ORDER BY a.tanggal ASC SEPARATOR ', ') AS tanggal_hadir,
    GROUP_CONCAT(
        CASE
            WHEN a.status = 'Hadir' THEN DATE_FORMAT(a.tanggal, '%d')
            ELSE NULL
        END
        ORDER BY a.tanggal ASC SEPARATOR ', '
    ) AS tanggal_hadir,
    GROUP_CONCAT(
        CASE
            WHEN a.status = 'Alpha' THEN DATE_FORMAT(a.tanggal, '%d')
            ELSE NULL
        END
        ORDER BY a.tanggal ASC SEPARATOR ', '
    ) AS tanggal_alpha
FROM
    tb_absensi a
JOIN
    tb_karyawan k ON a.karyawan_id = k.id
WHERE
    DATE_FORMAT(a.tanggal, '%Y-%m') = ? AND a.karyawan_id = ?
GROUP BY
    k.id;
";

        return $this->query($sql, [$periode, $id_karyawan])->fetchAll();

    }

}
