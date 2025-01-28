<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\GajiModel;

class PimpinanController extends Controller
{
    protected $karyawanModel;
    protected $absensiModel;
    protected $gajiModel;

    public function __construct($blade)
    {
        parent::__construct($blade, 'pimpinan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->gajiModel = new GajiModel();
    }

    public function index()
    {

        $karyawanCount = $this->karyawanModel->count()->jumlah;

        $data = [
          'page' => 'Dashboard',
          'subpage' => 'Dashboard',
          'karyawanCount' => $karyawanCount
        ];

        $this->view('pimpinan.dashboard', $data);

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

        $this->view('pimpinan.features.listGajiKaryawan', $data);

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
          'listKaryawan' => $karyawan_list,
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
            // default all
            $data_absensi = $this->absensiModel->all();
        }

        $data = [
          'data_absensi' => $data_absensi,
          'page' => 'Absensi Karyawan',
          'subpage' => 'Absensi Karyawan',
          'by' => $by ?? 'all'
        ];

        $this->view('features.listAbsensi', $data);
    }

    public function absensiBulanan()
    {
        $id = $_GET['id'];
        $periode = $_GET['periode'];

        $dataAbsensiBulanan = $this->absensiModel->absensiBulananKaryawan($id, $periode);

        $dataAbsensiHarian = array();
        $totalStatus = ['alpha' => 0, 'hadir' => 0, 'total_lembur' => 0];

        foreach($dataAbsensiBulanan as $hari) {
          if ($hari->status === 'Hadir') {
            $totalStatus['hadir'] += 1;
          } else if ($hari->status === 'Alpha') {
            $totalStatus['alpha'] += 1;
          }
            array_push($dataAbsensiHarian, [
              'id' => $hari->id,
              'title' => $hari->status,
              'start' => $hari->tanggal,
              'backgroundColor' => $hari->status === 'Alpha' ? '#dc3545' : '#28a745',
              'borderColor' => $hari->status === 'Alpha' ? '#dc3545' : '#28a745',
            ]);

            if($hari->lembur > 0) {
              $totalStatus['total_lembur'] += $hari->lembur;
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

        header("Location: {$_ENV['BASE_URL']}/pimpinan/gaji-karyawan");

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
        if ($id === 'all') {
          $dataGajiKaryawan = $this->gajiModel->allComplete();

          $this->view('pimpinan.features.detailGajiKaryawan', [
            'dataGajiKaryawan' => $dataGajiKaryawan,
            'page' => 'Gaji Karyawan',
            'subpage' => 'Laporan Gaji Karyawan'
          ]);
          exit();
        } else {
        $dataGajiKaryawan = $this->gajiModel->findByKaryawanId($id);
        $namaKaryawan = $this->karyawanModel->findById($id)->nama;
        $this->view('pimpinan.features.detailGajiKaryawan', [
          'dataGajiKaryawan' => $dataGajiKaryawan,
          'idKaryawan' => $id,
          'namaKaryawan' => $namaKaryawan,
          'page' => 'Gaji Karyawan',
          'subpage' => 'Laporan Gaji Karyawan'
        ]);

        }


      }

      header("Location: {$_ENV['BASE_URL']}/hrd/gaji-karyawan");


    }
}
