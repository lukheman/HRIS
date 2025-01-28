<?php

// TODO: status pembayaran gaji

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\GajiModel;

class KeuanganController extends Controller
{
    private $karyawanModel;
    private $absensiModel;
    private $gajiModel;


    public function __construct($blade)
    {
        parent::__construct($blade, 'keuangan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->gajiModel = new GajiModel();
    }

    public function index()
    {
        $data = ['page' => 'dashboard'];
        $this->view('keuangan.home', $data);
    }

    public function listGajiKaryawan()
    {

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

        $this->view('keuangan.features.listGajiKaryawan', $data);

    }

    public function updateGajiKaryawan()
    {

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

        header("Location: {$_ENV['BASE_URL']}/keuangan/gaji-karyawan");

    }

    public function cetakSlipGajiOne()
    {
        $id = $_POST['gaji_id'];

        $karyawan = $this->gajiModel->findById($id);

        $this->view('slipGajiOne', ['karyawan' => $karyawan]);

    }

    public function cetakSlipGajiAll()
    {

        $periode = $_GET['periode'];

        if(!isset($periode) || $periode === '') {
            $periode = date('Y-m');
        }

        $karyawan_list = $this->gajiModel->findByPeriode($periode);

        $data = [
          'karyawan_list' => $karyawan_list,
        ];

        $this->view('slipGajiAll', $data);

    }

    public function listAbsensi()
    {

        // set sorting method
        $by = $_GET['by'];

        if (isset($by) && $by !== '') {
            if ($by === 'month') {
                $periode = date('Y-m'); // periode default bulan ini
                $data_absensi = $this->absensiModel->findByBulan($periode);
            } elseif ($by === 'day') {
                $periode = date('Y-m-d'); // default today
                $data_absensi = $this->absensiModel->findByTanggal($periode);
            }
        } else {
            // $periode = date('Y-m-d'); // default today
            $data_absensi = $this->absensiModel->all();
        }


        $data = [
          'data_absensi' => $data_absensi,
          'page' => 'Absensi Karyawan',
          'subpage' => 'Absensi Karyawan',
          'by' => $by ?? 'all',
          // 'role' => $this->role
        ];

        $this->view('features.listAbsensi', $data);
    }

    public function absensiBulanan()
    {
        $id = $_GET['id'];
        $periode = $_GET['periode'];

        $dataAbsensi = $this->dataAbsensiBulanan($id, $periode);

        $prevMonth = date('Y-m', strtotime('-1 month', strtotime($periode . '-01')));
        $nextMonth = date('Y-m', strtotime('+1 month', strtotime($periode . '-01')));
        $initialDate = date('Y-m-d', strtotime($periode . '-01'));

        $karyawan  = $this->karyawanModel->findById($id);
        /*var_dump($dataAbsensi);*/
        /*exit();*/

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

        $this->view('features.absensiBulanan', $data);


    }

    public function dataAbsensiBulanan($id, $periode)
    {
        // $id: int
        // $periode: str(Y-m);

        $dataAbsensiBulanan = $this->absensiModel->absensiBulananKaryawan($id, $periode);

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


    public function selectKaryawanGaji() {
        $data_karyawan = $this->karyawanModel->all();

        $data = [
          'data_karyawan' => $data_karyawan,
          'page' => 'Gaji Karyawan',
          'subpage' => 'Pilih Karyawan'
        ];

        $this->view('features.gajiKaryawan.selectKaryawan', $data);

    }

    public function detailGajiKaryawan() {
      $id = $_GET['id'];

      if(isset($id) && $id !== '') {
        $dataGajiKaryawan = $this->gajiModel->findByKaryawanId($id);
        $namaKaryawan = $this->karyawanModel->findById($id)->nama;
        $this->view('features.gajiKaryawan.detailGajiKaryawan', [
          'dataGajiKaryawan' => $dataGajiKaryawan,
          'idKaryawan' => $id,
          'namaKaryawan' => $namaKaryawan,
          'page' => 'Gaji Karyawan',
          'subpage' => 'Laporan Gaji Karyawan'
        ]);
      }

      header("Location: {$_ENV['BASE_URL']}/hrd/gaji-karyawan");


    }

    public function addGajiKaryawan() {

      $id = $_POST['id'];
      $durasi_lembur = $_POST['durasi_lembur'];
      $gaji_lembur = $_POST['gaji_lembur'];
      $periode = $_POST['periode'];

      $result = $this->gajiModel->existKaryawanPeriode($id, $periode);

      if ($result->count <= 0) {
        $gaji_pokok  = $this->karyawanModel->findById($id)->gaji;

        $this->gajiModel->create([
          'karyawan_id' => $id,
          'periode' => $periode,
          'gaji_pokok' => $gaji_pokok,
          'gaji_lembur' => $gaji_lembur,
          'total_lembur' => $durasi_lembur,
          'gaji_total' => $gaji_pokok + $gaji_lembur
        ]);

      }

      header("Location: {$_ENV['BASE_URL']}/hrd/gaji-karyawan/detail?id={$id}");

    }

    public function deleteGajiKaryawan() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? ''; // id tb_gaji

        if($id !== '') {
            $this->gajiModel->delete($id);
        }
    }

}
