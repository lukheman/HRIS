<?php

namespace App\Utils;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

class AbsensiUtil
{
    private $absensiModel;
    private $karyawanModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->karyawanModel = new KaryawanModel();
    }

    public function getDataAbsensiBulanan($id, $periode)
    {
        $dataAbsensiBulanan = $this->absensiModel->absensiBulananKaryawan($id, $periode);

        $dataAbsensiHarian = array();
        $totalStatus = ['alpha' => 0, 'hadir' => 0, 'total_lembur' => 0];

        foreach($dataAbsensiBulanan as $hari) {
            if ($hari->status === 'Hadir') {
                $totalStatus['hadir']++;
            }
            if ($hari->status === 'Alpha') {
                $totalStatus['alpha']++;
            }
            if ($hari->lembur > 0) {
                $totalStatus['total_lembur'] += $hari->lembur;
            }

            array_push($dataAbsensiHarian, [
              'id' => $hari->id,
              'title' => $hari->status,
              'start' => $hari->tanggal,
              'backgroundColor' => $hari->status === 'Alpha' ? '#dc3545' : '#28a745',
              'borderColor' => $hari->status === 'Alpha' ? '#dc3545' : '#28a745',
            ]);

            if($hari->lembur > 0) {
                array_push($dataAbsensiHarian, [
                  'id' => $hari->id,
                  'title' => "Lembur {$hari->lembur}",
                  'start' => $hari->tanggal,
                  'backgroundColor' => '#fd7e14',
                  'borderColor' => '#fd7e14',
                ]);
            }

        }

        $prevMonth = date('Y-m', strtotime('-1 month', strtotime($periode . '-01')));
        $nextMonth = date('Y-m', strtotime('+1 month', strtotime($periode . '-01')));
        $initialDate = date('Y-m-d', strtotime($periode . '-01'));

        $karyawan  = $this->karyawanModel->findById($id);

        $data = [
          'dataAbsensi' => $dataAbsensiHarian,
          'prevMonth' => $prevMonth,
          'nextMonth' => $nextMonth,
          'id' => $id,
          'initialDate' => $initialDate,
          'karyawan' => $karyawan,
          'page' => 'Absensi Karyawan',
          'subpage' => 'Absensi Bulanan Karyawan',
          'totalStatus' => $totalStatus
        ];

        return $data;

    }

}
