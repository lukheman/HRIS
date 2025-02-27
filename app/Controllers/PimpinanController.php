<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\GajiModel;
use App\Models\PengaturanModel;

use App\Utils\AbsensiUtil;

use App\Interfaces\AbsensiInterface;

class PimpinanController extends Controller implements AbsensiInterface
{
    protected $karyawanModel;
    protected $absensiModel;
    protected $gajiModel;
    protected $pengaturanModel;
    private $absensiUtil;

    public function __construct($blade)
    {
        parent::__construct($blade, 'pimpinan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->gajiModel = new GajiModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->absensiUtil = new AbsensiUtil();
    }

    public function index()
    {
        $periode = getPrevMonth();

        $totalKaryawan = $this->karyawanModel->count()->jumlah;

        $totalGaji = $this->gajiModel->totalGaji($periode); // total gaji pada bulan sebelumnya

        $this->view('keuangan.dashboard', [
          'totalKaryawan' => $totalKaryawan,
          'totalGaji' => $totalGaji,
          'periode' => $periode,
          'page' => 'Dashboard',
          'subpage' => 'Dashboard',
        ]);
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
        $periode = $_GET['periode'] ?? 'all';

        if($periode === 'all') {
            $listKaryawan = $this->gajiModel->allComplete();
        } else {
            $periode = date('Y-m');
            $listKaryawan = $this->gajiModel->findByPeriode($periode);
        }

        $this->view('slipGajiAll', [
          'listKaryawan' => $listKaryawan,
        ]);

    }

    public function listAbsensi()
    {

        // set sorting method
        $by = $_GET['by'] ?? '';

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

        $data = $this->absensiUtil->getDataAbsensiBulanan($id, $periode);

        $this->view('features.absensiBulanan', $data);

    }

    public function updateGajiKaryawan()
    {
        header('Content-Type: application/json');

        $gajiLembur = $this->pengaturanModel->all()->gaji_lembur; // gaji lembur/jam

        $dataKaryawanAll = $this->karyawanModel->all();

        $dataGajiKaryawan = array(); // data karywan dan gaji karyawan

        foreach($dataKaryawanAll as $karyawan) {

            $lemburMonths = $this->absensiModel->calculateTotalLemburMonths($karyawan->id_karyawan);

            foreach ($lemburMonths as $month) {
                // cek apakah karyawan_id dengan periode yang sama telah ada di table tb_gaji
                // jika tidak maka tambahkan
                $result = $this->gajiModel->existKaryawanPeriode($karyawan->id_karyawan, $month->periode);
                if ($result->count > 0) {
                    continue;
                }

                $totalGajiLembur = ($month->total_lembur / 60) * $gajiLembur;
                $gajiTotal = $karyawan->gaji + $totalGajiLembur; // gaji pokok + gaji lembur bulan ini

                $data = [
                  'karyawan_id' => $karyawan->id_karyawan,
                  'periode' => $month->periode,
                  'gaji_pokok' => $karyawan->gaji,
                  'gaji_lembur' => $totalGajiLembur,
                  'total_lembur' => $month->total_lembur,
                  'gaji_total' => $gajiTotal,
                ];
                $this->gajiModel->create($data);
            }


        }

        echo json_encode([
          'status' => 'success',
          'message' => 'successfully update data gaji karyawan'
        ]);
    }

    public function selectKaryawanGaji()
    {
        $data_karyawan = $this->karyawanModel->all();

        $data = [
          'data_karyawan' => $data_karyawan,
          'page' => 'Gaji Karyawan',
          'subpage' => 'Pilih Karyawan'
        ];

        $this->view('features.gajiKaryawan.selectKaryawan', $data);

    }

    public function detailGajiKaryawan()
    {
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

    public function cetakLaporanGaji()
    {

        $id_karyawan = $_POST['id_karyawan'];
        $start_date = $_POST['start-date'];
        $end_date = $_POST['end-date'];

        if($id_karyawan === 'all') {
            $listKaryawan = $this->gajiModel->findBetweenPeriode($start_date, $end_date);
            $data = [
              'listKaryawan' => $listKaryawan,
              'start_date' => $start_date,
              'end_date' => $end_date
            ];
            $this->view('laporanGaji', $data);
        } else {
            $listGaji = $this->gajiModel->findKaryawanBetweenPeriode($id_karyawan, $start_date, $end_date);
            $karyawan = $this->karyawanModel->findById($id_karyawan);
            $data = [
              'listGaji' => $listGaji,
              'start_date' => $start_date,
              'end_date' => $end_date,
              'karyawan' => $karyawan
            ];
            $this->view('laporanGajiOne', $data);
        }

    }

    public function cetakLaporanAbsensi()
    {
        $id_karyawan = $_POST['id_karyawan'];
        $periode = $_POST['periode'];

        $header_date = generateHeaderDate($periode);

        if ($id_karyawan === 'all') {
            $listAbsensi = $this->absensiModel->getAbsensiMonth($periode);
            $this->view('laporanAbsensi', [
              'start_date' =>  $periode . '-01' ,
              'end_date' => addEndDate($periode),
              'header_date' => generateHeaderDate($periode),
              'listAbsensi' => $listAbsensi
            ]);
            exit();

        } else {
            $listAbsensi = $this->absensiModel->getAbsensiMonthByIdKaryawan($id_karyawan, $periode);
            $karyawan = $this->karyawanModel->findById($id_karyawan);
            $this->view('laporanAbsensi', [
              'start_date' =>  $periode . '-01' ,
              'end_date' => addEndDate($periode),
              'header_date' => generateHeaderDate($periode),
              'listAbsensi' => $listAbsensi,
              'karyawan' => $karyawan
            ]);
            exit();
        }

    }

    public function updateAbsensi()
    {
    }
}
