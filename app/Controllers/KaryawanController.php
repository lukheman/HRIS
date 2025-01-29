<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\UserModel;
use App\Models\GajiModel;

class KaryawanController extends Controller
{
    private $karyawanModel;
    private $absensiModel;
    private $userModel;
    private $gajiModel;

    public function __construct($blade)
    {

        parent::__construct($blade, 'karyawan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->userModel = new UserModel();
        $this->gajiModel = new GajiModel();

    }

    public function index()
    {
        $data = ['page' => 'dashboard'];
        $this->view('karyawan.home', $data);
    }

    function getCurrentKaryawan() {
      if (!isset($_SESSION['username'])) {
        throw new \RuntimeException('User not authenticated');
      }

      $karyawan = $this->karyawanModel->findByNik($_SESSION['username']);
      return $karyawan;
    }

    public function absensiBulanan()
    {
        $karyawan = $this->getCurrentKaryawan();

        $id = $karyawan->id;
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


    public function generateQrCodeProcess()
    {
        // Baca JSON input
        $data = json_decode(file_get_contents('php://input'), true);
        $nik = $data['nik'] ?? '';

        // Validasi NIK
        if (empty($nik)) {
            throw new \Exception('NIK tidak boleh kosong');
        }

        header('Content-Type: image/png');


        $qrString = generateQrCodeString($nik);

        echo $qrString;

    }

    public function detailGajiKaryawan() {
        $karyawan = $this->getCurrentKaryawan();

        $dataGajiKaryawan = $this->gajiModel->findByKaryawanId($karyawan->id);
        $this->view('karyawan.features.detailGajiKaryawan', [
          'dataGajiKaryawan' => $dataGajiKaryawan,
          'idKaryawan' => $karyawan->id,
          'namaKaryawan' => $karyawan->nama,
          'page' => 'Gaji Karyawan',
          'subpage' => 'Laporan Gaji Karyawan'
        ]);


    }

    public  function updatePassword() {

      $newPassword = $_POST['newPassword'];
      $confirmNewPassword = $_POST['confirmNewPassword'];

      $karyawan = $this->getCurrentKaryawan();
      $data = ['page' => 'Profile', 'karyawan' => $karyawan];

      if (isset($newPassword) && $newPassword !== '' && isset($confirmNewPassword) && $confirmNewPassword !== '') {
        if ($newPassword === $confirmNewPassword ){
          $this->userModel->update($_SESSION['user_id'], ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
          $data['message'] = 'Password berhasil diganti';
        } else {
          $data['message'] = 'Password tidak sama';
        }
      } else {
          $data['message'] = 'Password tidak boleh kosong';
      }

      $this->view('karyawan.profile', $data);
    }

    public function profile() {
      $karyawan = $this->getCurrentKaryawan();

      $this->view('karyawan.profile', ['page' => 'Profile', 'karyawan' => $karyawan]);
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
