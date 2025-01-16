<?php


namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

class HrdController extends Controller {

  protected $karyawanModel;
  protected $absensiModel;

  public function __construct($blade) {
    parent::__construct($blade);
    $this->karyawanModel = new KaryawanModel();
    $this->absensiModel = new AbsensiModel();
  }

  public function index() {

    $data = [
      'page' => 'dashboard'
    ];

    echo $this->blade->run('hrd.home', $data);

  }

  public function karyawanList() {
    $data_karyawan = $this->karyawanModel->all();

    $data = [
      'data_karyawan'=>$data_karyawan,
      'page' => 'Daftar Karyawan',
      'subpage' => 'Daftar Karyawan'
    ];

    echo $this->blade->run('hrd.features.karyawanList', $data);

  }

  public function karyawanAddForm() {
    $data = [
      'page' => 'Daftar Karyawan',
      'subpage' => 'Tambah Karyawan'
    ];
    echo $this->blade->run('hrd.features.karyawanAddForm', $data);
  }

  public function karyawanUpdateForm() {
    $id = $_POST['id'];

    $karyawanOne = $this->karyawanModel->findById($id);

    $data = [
      'page' => 'karyawan',
      'karyawanOne' => $karyawanOne,
      'page' => 'Daftar Karyawan',
      'subpage' => 'Update Karyawan'
    ];
    echo $this->blade->run('hrd.features.karyawanUpdateForm', $data);
  }


  public function karyawanCreate() {

    // TODO: cek apakah nik karyawan telah ada atau belum sebelum menambahkan karyawan
    $data = [
      'nama' => $_POST['nama'],
      'nik' => $_POST['nik'],
      'tanggal_lahir' => $_POST['tanggal_lahir'],
      'alamat' => $_POST['alamat'],
      'jabatan' => $_POST['jabatan'],
      'gaji' => $_POST['gaji'],
    ];

    $this->karyawanModel->create($data);
    $this->karyawan();

  }

  public function karyawanDelete() {
    // TODO: tambahakan alert ketika menghapus data bahawa seluruh data absensi karyawan juga akan terhapus
    $id = $_POST['id'];

    $this->karyawanModel->delete($id);
    header('Location: /hrd/karyawan');

  }

  public function karyawanUpdate() {

    // TODO: cek apakah nik karyawan telah ada atau belum sebelum menambahkan karyawan
    $id = $_POST['id'];

    $data = [
      'nama' => $_POST['nama'],
      'nik' => $_POST['nik'],
      'tanggal_lahir' => $_POST['tanggal_lahir'],
      'alamat' => $_POST['alamat'],
      'jabatan' => $_POST['jabatan'],
      'gaji' => $_POST['gaji'],
    ];

    $this->karyawanModel->update($id, $data);
    header('Location: /hrd/karyawan');

  }

  public function absensiAllShow() {

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

    echo $this->blade->run('hrd.features.absensiShow', $data);
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

    echo $this->blade->run('hrd.features.absensiBulanan', $data);


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

  public  function calendar() {

    echo $this->blade->run('hrd.features.calendar');

  }

}

?>
