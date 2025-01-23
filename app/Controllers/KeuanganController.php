<?php

// TODO: status pembayaran gaji

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\GajiModel;

class KeuanganController extends Controller
{
    private $role = 'Keuangan';

    private $karyawanModel;
    private $absensiModel;
    private $gajiModel;


    public function __construct($blade)
    {
        parent::__construct($blade);
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

}
