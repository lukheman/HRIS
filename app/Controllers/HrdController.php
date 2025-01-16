<?php


namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class HrdController extends Controller {

  protected $karyawanModel;
  protected $absensiModel;

  public function __construct($blade) {
    parent::__construct($blade);
    $this->karyawanModel = new KaryawanModel();
    $this->absensiModel = new AbsensiModel();
  }

  public function index() {

    $karyawanCount = $this->karyawanModel->count()->jumlah;

    $data = [
      'page' => 'Dashboard',
      'subpage' => 'Dashboard',
      'karyawanCount' => $karyawanCount
    ];

    echo $this->blade->run('hrd.dashboard', $data);

  }

  public function listKaryawan() {
    $data_karyawan = $this->karyawanModel->all();

    $data = [
      'data_karyawan'=>$data_karyawan,
      'page' => 'Daftar Karyawan',
      'subpage' => 'Daftar Karyawan'
    ];

    echo $this->blade->run('hrd.features.listKaryawan', $data);

  }

  public function addKaryawanForm() {
    $data = [
      'page' => 'Daftar Karyawan',
      'subpage' => 'Tambah Karyawan'
    ];
    echo $this->blade->run('hrd.features.addKaryawanForm', $data);
  }

  public function updateKaryawanForm() {
    $id = $_GET['id'];

    $karyawanOne = $this->karyawanModel->findById($id);

    $data = [
      'page' => 'karyawan',
      'karyawanOne' => $karyawanOne,
      'page' => 'Daftar Karyawan',
      'subpage' => 'Update Karyawan'
    ];
    echo $this->blade->run('hrd.features.updateKaryawanForm', $data);
  }


  public function createKaryawan() {

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
    header('Location: /hrd/karyawan');

  }

  public function deleteKaryawan() {
    // TODO: tambahakan alert ketika menghapus data bahawa seluruh data absensi karyawan juga akan terhapus
    $id = $_POST['id'];

    $this->karyawanModel->delete($id);
    header('Location: /hrd/karyawan');

  }

  public function updateKaryawan() {

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

    echo $this->blade->run('hrd.features.listAbsensi', $data);
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

  public function scanQrCode() {

    $data = [
      'page' => 'Scan QR Code',
      'subpage' => 'Scan QR Code',
    ];

    echo $this->blade->run('hrd.features.scanQrCode', $data);
  }

  public function generateQrCode() {

    $nama = $_GET['nama'] ?? '';

    if (isset($nama) && $nama !== '') {
      $listKaryawan = $this->karyawanModel->findByNama($nama);
      $data = [
        'page' => 'Generate QR Code',
        'subpage' => 'Generate QR Code',
        'listKaryawan' => $listKaryawan
      ];
      echo $this->blade->run('hrd.features.generateQrCode', $data);
    } else {
      $data = [
        'page' => 'Generate QR Code',
        'subpage' => 'Generate QR Code',
      ];
      echo $this->blade->run('hrd.features.generateQrCode', $data);
    }

  }

  public function generateQrCodeProcess() {

    $nik = $_GET['nik'];

    $qrCode = new QrCode($nik);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $qrPath = 'storage/qrcodes/' . $nik. '.png';
    $result->saveToFile($qrPath);
    return $qrPath;
  }


}

?>
