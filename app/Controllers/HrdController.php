<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class HrdController extends Controller
{
    protected $karyawanModel;
    protected $absensiModel;

    public function __construct($blade)
    {
        parent::__construct($blade);
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {

        $karyawanCount = $this->karyawanModel->count()->jumlah;

        $data = [
          'page' => 'Dashboard',
          'subpage' => 'Dashboard',
          'karyawanCount' => $karyawanCount
        ];

        echo $this->blade->run('hrd.dashboard', $data);

    }

    public function listKaryawan()
    {
        $data_karyawan = $this->karyawanModel->all();

        $data = [
          'data_karyawan' => $data_karyawan,
          'page' => 'Daftar Karyawan',
          'subpage' => 'Daftar Karyawan'
        ];

        echo $this->blade->run('hrd.features.listKaryawan', $data);

    }

    public function addKaryawanForm()
    {
        $data = [
          'page' => 'Daftar Karyawan',
          'subpage' => 'Tambah Karyawan'
        ];
        echo $this->blade->run('hrd.features.addKaryawanForm', $data);
    }

    public function updateKaryawanForm()
    {
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


    public function createKaryawan()
    {

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
        header("Location: {$_ENV['BASE_URL']}/hrd/karyawan");

    }

    public function deleteKaryawan()
    {
        // TODO: tambahakan alert ketika menghapus data bahawa seluruh data absensi karyawan juga akan terhapus
        $id = $_POST['id'];

        $this->karyawanModel->delete($id);
        header("Location: {$_ENV['BASE_URL']}/hrd/karyawan");

    }

    public function updateKaryawan()
    {

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
        header("Location: {$_ENV['BASE_URL']}/hrd/karyawan");

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

        echo $this->blade->run('hrd.features.absensiBulanan', $data);


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

    public function scanQrCode()
    {

        $data = [
          'page' => 'Scan QR Code',
          'subpage' => 'Scan QR Code',
        ];

        echo $this->blade->run('hrd.features.scanQrCode', $data);
    }

    public function generateQrCode()
    {

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

    // private function generateAndSave($nik)
    // {
    //     // Sanitasi filename
    //     $safeNik = preg_replace('/[^a-zA-Z0-9]/', '', $nik);
    //
    //     // Generate QR Code
    //     $qrCode = new QrCode($nik);
    //     $writer = new PngWriter();
    //     $result = $writer->write($qrCode);
    //
    //     // Pastikan direktori ada
    //     $directory = __DIR__ . '/../../public/qrcodes/';
    //     if (!file_exists($directory)) {
    //         mkdir($directory, 0755, true);
    //     }
    //
    //     // Simpan file
    //     $qrPath = '/qrcodes/' . $safeNik . '.png';
    //     $fullPath = $directory . $safeNik . '.png';
    //     $result->saveToFile($fullPath);
    //
    //     return $qrPath;
    // }

    public function generateQrCodeString($nik) {

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

    public function saveQrCode()
    {
      // TODO: validasi ketika nik kosong
        $nik = $_POST['nik'];

        $qrCodeBase64 = base64_encode($this->generateQrCodeString($nik));

        $karyawan = $this->karyawanModel->findByNik($nik);

        $data = [
          'qrCodeBase64' => $qrCodeBase64,
          'karyawan' => $karyawan
        ];

        echo $this->blade->run('qrcodeKaryawan', $data);

    }

    public function processScan() {
      // TODO: handling ketika nik kosong
      // TODO: handling jam lembur
      header('Content-Type: application/json');

      // Baca JSON input
      $data = json_decode(file_get_contents('php://input'), true);
      $nik = $data['nik'] ?? '';

      // $nik = $_POST['nik'] ?? '';

      // Validasi NIK
      if (empty($nik)) {
        throw new \Exception('NIK tidak boleh kosong');
      }

      $karyawan = $this->karyawanModel->findByNik($nik);

      if(!$karyawan) {
        echo json_encode(['status' => 'failed', 'message' => 'Karyawan Tidak Terdaftar']);
        exit();
      }

      $today = date('Y-m-d');

      $absen = $this->absensiModel->isKaryawanAbsen($karyawan->id, $today);


      if(!$absen) {
        $data = [
          'karyawan_id' => $karyawan->id,
          'tanggal' => $today,
          'jam_masuk' => date('H:i:s'),
          'status' => 'Hadir'
        ];

        $this->absensiModel->create($data);

        echo json_encode(['status' => 'success', 'karyawan' => $karyawan, 'message' => 'Absen Masuk']);

      } else if(is_null($absen->jam_keluar)) {
        $data = [
          'jam_keluar' => date('H:i:s')
        ];
        $this->absensiModel->update($absen->id, $data);
        echo json_encode(['status' => 'success', 'karyawan' => $karyawan, 'message' => 'Absen Keluar']);
      } else {
        echo json_encode(['status' => 'success', 'karyawan' => $karyawan, 'message' => 'Anda Telah Absen Hari Ini']);
      }


    }

}
