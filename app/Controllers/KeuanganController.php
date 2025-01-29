<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\GajiModel;

use App\Interfaces\AbsensiInterface;

use App\Utils\AbsensiUtil;

class KeuanganController extends Controller implements AbsensiInterface
{
    private $karyawanModel;
    private $absensiModel;
    private $gajiModel;
    private $absensiUtil;

    public function __construct($blade)
    {
        parent::__construct($blade, 'keuangan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->gajiModel = new GajiModel();
        $this->absensiUtil = new AbsensiUtil();
    }

    public function index()
    {
        $dataAbsensi = $this->absensiModel->today();

        $totalStatus = ['hadir' => 0, 'alpha' => 0 ];

        foreach ($dataAbsensi as $hari) {
            if ($hari->status === 'Hadir') {
                $totalStatus['hadir'] += 1;
            } elseif ($hari->status === 'Alpha') {
                $totalStatus['alpha'] += 1;
            }
        }

        $data = ['page' => 'dashboard' , 'totalStatus' => $totalStatus];
        $this->view('keuangan.dashboard', $data);
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

        $data = $this->absensiUtil->getDataAbsensiBulanan($id, $periode);

        $this->view('features.absensiBulanan', $data);

    }

    public function updateAbsensi()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id_absensi = $data['id_absensi'] ?? '';
        $durasi_lembur = $data['durasi_lembur'] ?? '';

        if (isset($id_absensi) && $id_absensi !== '' && isset($durasi_lembur) && $durasi_lembur !== '') {
            $this->absensiModel->update($id_absensi, ['lembur' => $durasi_lembur]);
        }
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

                $this->view('keuangan.features.detailGajiKaryawan', [
                  'dataGajiKaryawan' => $dataGajiKaryawan,
                  'page' => 'Gaji Karyawan',
                  'subpage' => 'Laporan Gaji Karyawan'
                ]);
                exit();
            } else {
                $dataGajiKaryawan = $this->gajiModel->findByKaryawanId($id);
                $namaKaryawan = $this->karyawanModel->findById($id)->nama;
                $this->view('keuangan.features.detailGajiKaryawan', [
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

    public function addGajiKaryawan()
    {

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

        header("Location: {$_ENV['BASE_URL']}/keuangan/gaji-karyawan/detail?id={$id}");

    }

    public function deleteGajiKaryawan()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? ''; // id tb_gaji

        if($id !== '') {
            $this->gajiModel->delete($id);
        }
    }

    public function approveGajiKaryawan()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? ''; // id tb_gaji

        if($id !== '') {
            $this->gajiModel->update($id, ['status' => 'DISETUJUI']);
        }
    }

    public function approveSelectedGajiKaryawan()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $selected_id = $data['selected_id'] ?? ''; // id tb_gaji

        if($selected_id !== '') {
            foreach ($selected_id as $id) {
                $this->gajiModel->update($id, ['status' => 'DISETUJUI']);
            }
        }
    }

    public function pendingSelectedGajiKaryawan()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $selected_id = $data['selected_id'] ?? ''; // id tb_gaji

        if($selected_id !== '') {
            foreach ($selected_id as $id) {
                $this->gajiModel->update($id, ['status' => 'PENDING']);
            }
        }
    }

    public function pendingGajiKaryawan()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? ''; // id tb_gaji

        if($id !== '') {
            $this->gajiModel->update($id, ['status' => 'PENDING']);
        }
    }



}
