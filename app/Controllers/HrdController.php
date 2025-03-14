<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KaryawanModel;
use App\Models\UserModel;
use App\Models\GajiModel;
use App\Models\JabatanModel;
use App\Models\PengaturanModel;

use App\Interfaces\AbsensiInterface;

use App\Utils\AbsensiUtil;

class HrdController extends Controller implements AbsensiInterface
{
    private $karyawanModel;
    private $absensiModel;
    private $userModel;
    private $gajiModel;
    private $absensiUtil;
    private $jabatanModel;
    private $pengaturanModel;

    public function __construct($blade)
    {
        parent::__construct($blade, 'hrd');
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->userModel = new UserModel();
        $this->gajiModel = new GajiModel();
        $this->jabatanModel = new JabatanModel();
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
              'id_jabatan' => $_POST['id_jabatan'],
              'gaji_lembur' => $_POST['gaji_lembur'],
            ]);

            # buat akun karyawan
            $this->userModel->create([
              'username' => $_POST['nik'],
              'password' => password_hash(str_replace('-', '', $_POST['tanggal_lahir']), PASSWORD_DEFAULT),
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
            $karyawanNik = $this->karyawanModel->findById($id)->nik;
            $this->userModel->deleteByUsername($karyawanNik);
            $this->karyawanModel->delete($id);
        }

    }

    public function updateKaryawan()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        $oldNik = $data['old_nik'];
        $nik = $data['nik'];
        $id = $data['id'];

        if(($nik !== $oldNik) && $this->karyawanModel->findByNik($nik)) {
            $response = ['status' => 'error', 'message' => 'NIK Telah terdaftar'];
            echo json_encode($response);
            exit();
        } else {


            $dataBaru = [
              'nama' => $data['nama'],
              'nik' => $data['nik'],
              'tanggal_lahir' => $data['tanggal_lahir'],
              'alamat' => $data['alamat'],
              'gaji_lembur' => $data['gaji_lembur'],
              'id_jabatan' => $data['id_jabatan'],
              'gaji_lembur' => $data['gaji_lembur'],
            ];

            $this->karyawanModel->update($id, $dataBaru);

            $response = [ 'status' => 'success', 'message' => 'Data karyawan berhasil diupdate'];
            echo json_encode($response);
            exit();
        }
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

    public function updateAbsensi()
    {
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

        $radiusMaksimal = $this->pengaturanModel->radius_maksimal;

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

        $latitude = $data['position'][0];
        $longitude = $data['position'][1];

        $jarak = hitungJarak($latitude, $longitude, $this->pengaturanModel->latitude, $this->pengaturanModel->longitude);

        if($jarak <= $radiusMaksimal) {
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
                $jam_keluar = $this->pengaturanModel->jam_keluar();

                $waktuSekarang = date('H:i:s');

                // Konversi ke detik
                $detik_keluar = strtotime($jam_keluar);
                $detik_sekarang = strtotime($waktuSekarang);

                // Hitung selisih dalam menit
                $lembur = ($detik_sekarang - $detik_keluar) / 60;

                if($lembur > 0) {
                    $data = [
                      'jam_keluar' => $waktuSekarang,
                      'lembur' => $lembur
                    ];

                } else {
                    $data = [
                      'jam_keluar' => $waktuSekarang,
                    ];
                }


                $this->absensiModel->update($absen->id, $data);
                echo json_encode(['status' => 'success', 'karyawan' => $karyawan, 'message' => 'Absen Keluar']);
            } else {
                echo json_encode(['status' => 'success', 'karyawan' => $karyawan, 'message' => 'Anda Telah Absen Hari Ini']);
            }

        } else {
            echo json_encode(['status' => 'failed', 'message' => 'Anda berada di luar lokasi absen']);
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

        header("Location: {$_ENV['BASE_URL']}/hrd/gaji-karyawan/detail?id={$id}");

    }

    public function deleteGajiKaryawan()
    {
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
        }




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

    public function pengaturan()
    {
        $pengaturan = $this->pengaturanModel->all();

        return $this->view('hrd.pengaturan', [
          'page' => 'Pengaturan',
          'subpage' => 'Pengaturan',
          'pengaturan' => $pengaturan
        ]);
    }


    public function updatePengaturan()
    {
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        $this->pengaturanModel->updateData($data);

        // header("Location: {$_ENV['BASE_URL']}/hrd/pengaturan");

        echo json_encode([
            'status' => 'success',
            'message' => 'Pengaturan berhasil diupdate', 
            'data' => $this->pengaturanModel->all()
        ]);
    }
  

    public function jabatan()
    {

        $jabatan = $this->jabatanModel->all();

        return $this->view('hrd.jabatan', [
          'page' => 'Jabatan',
          'subpage' => 'Jabatan',
          'jabatan' => $jabatan
        ]);
    }


    public function showJabatan()
    {
        header("Content-Type: application/json");

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, "message" => "ID tidak ditemukan"]);
            return;
        }

        $jabatan = $this->jabatanModel->find($id);



        echo json_encode([
          'status' => true,
          'message' => 'berhasil mendapatkan data jabatan',
          'data' => $jabatan
        ]);

    }

    public function addJabatan()
    {

        $this->jabatanModel->create([
          'jabatan' => $_POST['jabatan'],
          'gaji' => $_POST['gaji'],
        ]);

        header("Location: {$_ENV['BASE_URL']}/hrd/jabatan");

    }

    public function updateJabatan()
    {
        $id = $_POST['id_jabatan'] ?? null;

        $this->jabatanModel->update($id, [
          'jabatan' => $_POST['jabatan'],
          'gaji' => $_POST['gaji'],
        ]);

        header("Location: {$_ENV['BASE_URL']}/hrd/jabatan");

    }

    public function deleteJabatan()
    {
        header("Content-Type: application/json");

        $id = $_POST['id'] ?? null;

        $this->jabatanModel->delete($id);

        echo json_encode([
          'success' => true,
          'message' => 'Berhasil menghapus jabatan',
        ]);

    }

}
