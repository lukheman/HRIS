<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\UserModel;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class KaryawanController extends Controller
{
    private $karyawanModel;
    private $absensiModel;
    private $userModel;

    public function __construct($blade)
    {

        parent::__construct($blade, 'karyawan');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->userModel = new UserModel();

    }

    public function index()
    {
        $data = ['page' => 'dashboard'];
        $this->view('karyawan.home', $data);
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

    public function generateQrCodeString($nik)
    {

        // Membuat QR Code langsung ke output
        $qrCode = Builder::create()
          ->writer(new PngWriter())       // Menentukan format PNG
          ->data($nik)   // Data yang akan dienkode
          ->size(300)                     // Ukuran QR Code
          ->margin(10)                    // Margin di sekitar QR Code
          ->build();

        return $qrCode->getString();

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


        $qrString = $this->generateQrCodeString($nik);

        echo $qrString;

    }

    public  function updatePassword() {

      $newPassword = $_POST['newPassword'];
      $confirmNewPassword = $_POST['confirmNewPassword'];

      $karyawan = $this->karyawanModel->findByNik($_SESSION['username']);
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
      $karyawan = $this->karyawanModel->findByNik($_SESSION['username']);

      $this->view('karyawan.profile', ['page' => 'Profile', 'karyawan' => $karyawan]);
    }




}
