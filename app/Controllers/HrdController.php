<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\UserModel;
use App\Models\GajiModel;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class HrdController extends Controller
{
    private $karyawanModel;
    private $absensiModel;
    private $userModel;
    private $gajiModel;

    public function __construct($blade)
    {
        parent::__construct($blade, 'hrd');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->userModel = new UserModel();
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

        // $this->view('hrd.dashboard', $data);
        $this->view('hrd.dashboard', $data);

    }

    public function listKaryawan()
    {
        $data_karyawan = $this->karyawanModel->all();

        $data = [
          'data_karyawan' => $data_karyawan,
          'page' => 'Daftar Karyawan',
          'subpage' => 'Daftar Karyawan'
        ];

        $this->view('hrd.features.listKaryawan', $data);

    }

    public function addKaryawanForm()
    {
        $data = [
          'page' => 'Daftar Karyawan',
          'subpage' => 'Tambah Karyawan'
        ];
        $this->view('hrd.features.addKaryawanForm', $data);
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
        $this->view('hrd.features.updateKaryawanForm', $data);
    }


    public function createKaryawan()
    {
        if(!$this->karyawanModel->findByNik($_POST['nik'])) {

            # buat data karyawawan di tb_karyawan
            $this->karyawanModel->create([
              'nama' => $_POST['nama'],
              'nik' => $_POST['nik'],
              'tanggal_lahir' => $_POST['tanggal_lahir'],
              'alamat' => $_POST['alamat'],
              'jabatan' => $_POST['jabatan'],
              'gaji' => $_POST['gaji'],
            ]);

            # buat akun karyawan
            $this->userModel->create([
              'username' => $_POST['nik'],
              'password' => password_hash(str_replace('-', '', $_POST['tanggal_lahir']), PASSWORD_DEFAULT),
              'name' => $_POST['nama'],
              'name' => $_POST['nama'],
              'role' => 'KARYAWAN'
            ]);

            header("Location: {$_ENV['BASE_URL']}/hrd/karyawan");

        } else {
            $data = [ 'message' => 'NIK Telah terdaftar'];
            $this->view('hrd.features.addKaryawanForm', $data);
        }

    }

    public function deleteKaryawan()
    {
        // Baca JSON input
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? '';

        if($id !== '') {
            $this->karyawanModel->delete($id);
        }

    }

    public function updateKaryawan()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $oldNik = $data['old-nik'];
        $nik = $data['nik'];
        $id = $data['id'];

        if(($nik !== $oldNik) && $this->karyawanModel->findByNik($nik)) {
            $response = ['status' => 'error', 'message' => 'NIK Telah terdaftar'];
            echo json_encode($response);
            exit();
        } else {


            $data = [
              'nama' => $data['nama'],
              'nik' => $data['nik'],
              'tanggal_lahir' => $data['tanggal_lahir'],
              'alamat' => $data['alamat'],
              'jabatan' => $data['jabatan'],
              'gaji' => $data['gaji'],
            ];

            $this->karyawanModel->update($id, $data);

            $response = [ 'status' => 'success', 'message' => 'NIK Telah terdaftar'];
            echo json_encode($response);
            exit();
        }
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

    public function updateAbsensi() {
      $data = json_decode(file_get_contents('php://input'), true);
      $id_absensi = $data['id_absensi'] ?? '';
      $durasi_lembur = $data['durasi_lembur'] ?? '';

      if (isset($id_absensi) && $id_absensi !== '' && isset($durasi_lembur) && $durasi_lembur !== '') {
        $this->absensiModel->update($id_absensi, ['lembur' => $durasi_lembur]);
      }
    }

    public function scanQrCode()
    {

        $data = [
          'page' => 'Scan QR Code',
          'subpage' => 'Scan QR Code',
        ];

        $this->view('hrd.features.scanQrCode', $data);
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
            $this->view('hrd.features.generateQrCode', $data);
        } else {
            $data = [
              'page' => 'Generate QR Code',
              'subpage' => 'Generate QR Code',
            ];
            $this->view('hrd.features.generateQrCode', $data);
        }

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

    public function saveQrCode()
    {
        $nik = $_POST['nik'];

        $qrCodeBase64 = base64_encode(generateQrCodeString($nik));

        $karyawan = $this->karyawanModel->findByNik($nik);

        $data = [
          'qrCodeBase64' => $qrCodeBase64,
          'karyawan' => $karyawan
        ];

        $this->view('qrcodeKaryawan', $data);

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

          $this->view('features.gajiKaryawan.detailGajiKaryawan', [
            'dataGajiKaryawan' => $dataGajiKaryawan,
            'page' => 'Gaji Karyawan',
            'subpage' => 'Laporan Gaji Karyawan'
          ]);
          exit();
        } else {
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

}
