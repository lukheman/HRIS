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
    $data_karyawan = $this->karyawanModel->all();

    $data = [
      'data_karyawan'=>$data_karyawan,
      'page' => 'dashboard'
    ];

    echo $this->blade->run('hrd.home', $data);

  }

  public function karyawan() {
    $data_karyawan = $this->karyawanModel->all();

    $data = [
      'data_karyawan'=>$data_karyawan,
      'page' => 'karyawan'

    ];

    echo $this->blade->run('hrd.features.karyawanShow', $data);

  }

  public function karyawanAddForm() {
    $data = [
      'page' => 'karyawanAdd'
    ];
    echo $this->blade->run('hrd.features.karyawanAddForm', $data);
  }

  public function karyawanUpdateForm() {
    $id = $_POST['id'];

    $karyawanOne = $this->karyawanModel->findById($id);

    $data = [
      'page' => 'karyawan',
      'karyawanOne' => $karyawanOne
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

  public function absensi() {
    $data_absensi = $this->absensiModel->all();

    $data = [
      'data_absensi' => $data_absensi,
      'page' => 'absensi',
    ];
    echo $this->blade->run('hrd.features.absensiShow', $data);
  }

}

?>
