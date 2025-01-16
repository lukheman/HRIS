<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\GajiModel;

class PimpinanController extends Controller {

  protected $karyawanModel;
  protected $absensiModel;
  protected $gajiModel;

  public function __construct($blade) {
    parent::__construct($blade);
    $this->karyawanModel = new KaryawanModel();
    $this->absensiModel = new AbsensiModel();
    $this->gajiModel = new GajiModel();
  }

  public function index() {

    $karyawanCount = $this->karyawanModel->count()->jumlah;

    $data = [
      'page' => 'Dashboard',
      'subpage' => 'Dashboard',
      'karyawanCount' => $karyawanCount
    ];

    echo $this->blade->run('pimpinan.dashboard', $data);

  }

  public function listGajiKaryawan() {

    $periode = $_GET['periode'];

    if(!isset($periode) || $periode === '') {
      $periode = date('Y-m');
    }


    $dataGajiKaryawan = $this->gajiModel->findByPeriode($periode);

    $bulan = date('F', strtotime($periode . "-01"));  // Menambahkan hari untuk memvalidasi tanggal

    $data = [
      'dataGajiKaryawan' => $dataGajiKaryawan,
      'page' => 'Gaji Karyawan',
      'subpage' => 'Gaji Karyawan',
      'bulan' => $bulan,
      'periode' => $periode,
    ];

    echo $this->blade->run('pimpinan.features.listGajiKaryawan', $data);

  }

  public function cetakSlipGajiOne() {
    $id = $_POST['gaji_id'];

    $karyawan = $this->gajiModel->findById($id);

    echo $this->blade->run('slipGajiOne', ['karyawan' => $karyawan]);

  }

  public function cetakSlipGajiAll() {

    $periode = $_GET['periode'];

    if(!isset($periode) || $periode === '') {
      $periode = date('Y-m');
    }

    $karyawan_list = $this->gajiModel->findByPeriode($periode);

      $data = [
        'karyawan_list' => $karyawan_list,
      ];

    echo $this->blade->run('slipGajiAll', $data);

  }

  public function listAbsensi() {

    // set sorting method
    $by = $_GET['by'];

    if (isset($by) && $by !== '') {
      if ($by === 'month') {
        $periode = date('Y-m'); // periode default bulan ini
        $data_absensi = $this->absensiModel->findByBulan($periode);
      } else if ($by === 'day') {
        $periode = date('Y-m-d'); // default today
        $data_absensi = $this->absensiModel->findByTanggal($periode);
      }
    } else {
      $periode = date('Y-m-d'); // default today
      $data_absensi = $this->absensiModel->findByTanggal($periode);
    }


    $data = [
      'data_absensi' => $data_absensi,
      'page' => 'Absensi Karyawan',
      'subpage' => 'Absensi Karyawan',
      'by' => $by ?? 'day'
    ];

    echo $this->blade->run('pimpinan.features.listAbsensi', $data);
  }

  public function absensiBulanan() {
    $id = $_GET['id'];
    $periode = $_GET['periode'];

    $dataAbsensi = $this->dataAbsensiBulanan($id, $periode);

    $prevMonth = date('Y-m', strtotime('-1 month', strtotime($periode . '-01')));
    $nextMonth = date('Y-m', strtotime('+1 month', strtotime($periode . '-01')));
    $initialDate = date('Y-m-d', strtotime($periode . '-01'));

    $karyawan  = $this->karyawanModel->findById($id);

    $data = [
      'dataAbsensi' => $dataAbsensi,
      'prevMonth' => $prevMonth,
      'nextMonth' => $nextMonth,
      'id' => $id,
      'initialDate' => $initialDate,
      'karyawan' => $karyawan,
      'page' => 'Absensi Karyawan',
      'subpage' => 'Absensi Bulanan Karyawan',
    ];

    echo $this->blade->run('pimpinan.features.absensiBulanan', $data);


  }

  public function dataAbsensiBulanan($id, $periode) {
    // $id: int
    // $periode: str(Y-m);

    $dataAbsensiBulanan= $this->absensiModel->absensiBulananKaryawan($id, $periode);

    $dataAbsensiHarian = array();

    foreach($dataAbsensiBulanan as $hari) {
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


    return $dataAbsensiHarian;

  }

}
