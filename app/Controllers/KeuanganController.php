<?php

// TODO: status pembayaran gaji

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\GajiModel;

class KeuanganController extends Controller {
  private $role = 'Keuangan';

  private $karyawanModel;
  private $absensiModel;
  private $gajiModel;


  public function __construct($blade) {
    parent::__construct($blade);
    $this->karyawanModel = new KaryawanModel();
    $this->absensiModel= new AbsensiModel();
    $this->gajiModel = new GajiModel();
  }

  public function index() {
    $data = ['page' => 'dashboard'];
    echo $this->blade->run('keuangan.home', $data);
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

    echo $this->blade->run('keuangan.features.listGajiKaryawan', $data);

  }

  public function gajiKaryawanVerifikasiShow() {
    // TODO: sembuyikna atau enkripsi data id yang dikirim di url

    // fungsi ini untuk menampilkan data gaji karyawan setiap bulan
    // default: bulan ini

    $periode = '2025-01';
    $gajiLembur = 10000; // gaji lembur per/menit

    $dataKaryawanAll = $this->karyawanModel->all();

    $dataGajiKaryawan = array(); // data karywan dan gaji karyawan

    foreach($dataKaryawanAll as $karyawan) {
      $dataAbsensiBulanan = $this->absensiModel->absensiBulananKaryawan($karyawan->id, $periode);
      $totalMenitLembur = 0; // total lembur bulan ini dalam satuan menit

      foreach($dataAbsensiBulanan as $hari) {
        $totalMenitLembur += $hari->lembur;
      }

      $totalGajiLembur = $totalMenitLembur * $gajiLembur;
      $gajiTotal = $karyawan->gaji + $totalGajiLembur; // gaji pokok + gaji lembur bulan ini

      array_push($dataGajiKaryawan, [
        'karyawan_id' => $karyawan->id,
        'nama' => $karyawan->nama,
        'gaji_pokok' => $karyawan->gaji,
        'gaji_lembur' => $totalGajiLembur,
        'total_lembur' => $totalMenitLembur,
        'gaji_total' => $gajiTotal,
        'periode' => $periode,
      ]);
    }

    $data = [
      'role' => $this->role,
      'page' => 'Verifikasi Gaji Karyawan',
      'dataGajiKaryawan' => $dataGajiKaryawan
    ];

    echo $this->blade->run('keuangan.features.gajiKaryawanVerifikasiShow', $data);
  }

  public function gajiKaryawanVerifikasi() {

      $data = [
      'karyawan_id'  => $_POST['karyawan_id'],
      'gaji_pokok'   => $_POST['gaji_pokok'],
      'gaji_lembur'  => $_POST['gaji_lembur'],
      'total_lembur' => $_POST['total_lembur'],
      'gaji_total'   => $_POST['gaji_total'],
      'periode'      => $_POST['periode'],
    ];

    foreach($data as $key => $value ) {
      if (!isset($value) || $value === '') {
        // TODO: buat response yang lebih bagus
        echo 'ada field yang tidak lengkap';
        exit();
      }
    }


    $this->gajiModel->create($data);
    echo "berhasil";

  }

  public function updateGajiKaryawan() {

    $periode = $_GET['periode'] ?? date('Y-m');

    $gajiLembur = 10000; // gaji lembur per/menit

    $dataKaryawanAll = $this->karyawanModel->all();

    $dataGajiKaryawan = array(); // data karywan dan gaji karyawan

    foreach($dataKaryawanAll as $karyawan) {
      // cek apakah karyawan_id dengan periode yang sama telah ada di table tb_gaji
      // jika tidak maka tambahkan

      $result = $this->gajiModel->existKaryawanPeriode($karyawan->id, $periode);

      if ($result->count > 0) {
        continue;
      }

      $dataAbsensiBulanan = $this->absensiModel->absensiBulananKaryawan($karyawan->id, $periode);
      $totalMenitLembur = 0; // total lembur bulan ini dalam satuan menit

      foreach($dataAbsensiBulanan as $hari) {
        $totalMenitLembur += $hari->lembur;
      }

      $totalGajiLembur = $totalMenitLembur * $gajiLembur;
      $gajiTotal = $karyawan->gaji + $totalGajiLembur; // gaji pokok + gaji lembur bulan ini

      $data = [
        'karyawan_id' => $karyawan->id,
        'periode' => $periode,
        'gaji_pokok' => $karyawan->gaji,
        'gaji_lembur' => $totalGajiLembur,
        'total_lembur' => $totalMenitLembur,
        'gaji_total' => $gajiTotal,
      ];

      $this->gajiModel->create($data);

    }

    header('Location: /keuangan/gaji-karyawan');

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

}
