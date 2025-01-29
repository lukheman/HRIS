<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

class HomeController extends Controller
{
    private $absensiModel;
    private $karyawanModel;

    public function __construct($blade)
    {
        parent::__construct($blade);
        $this->absensiModel = new AbsensiModel();
        $this->karyawanModel = new KaryawanModel();
    }

    public function index()
    {
        $data = [

          'title' => 'Home Page',
          'content' => 'Welcome akmal ti website ku',

        ];
        echo $this->blade->run('home', $data);
    }

    public function scanQrCode()
    {

        $data = [
          'page' => 'Scan QR Code',
          'subpage' => 'Scan QR Code',
        ];


        $this->view('scanQrCode');
    }

    public function processScan()
    {
        header('Content-Type: application/json');

        // Baca JSON input
        $data = json_decode(file_get_contents('php://input'), true);
        $nik = $data['nik'] ?? '';

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

        } elseif(is_null($absen->jam_keluar)) {
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
