<?php

namespace App\Controllers;

use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\UserModel;
use App\Models\GajiModel;

use App\Utils\AbsensiUtil;

class KaryawanController extends Controller
{
    private $karyawanModel;
    private $absensiModel;
    private $userModel;
    private $gajiModel;
    private $absensiUtil;

    public function __construct($blade)
    {
        parent::__construct($blade, "karyawan");
        $this->karyawanModel = new KaryawanModel();
        $this->absensiModel = new AbsensiModel();
        $this->userModel = new UserModel();
        $this->gajiModel = new GajiModel();
        $this->absensiUtil = new AbsensiUtil();
    }

    public function index()
    {
        $data = ["page" => "dashboard"];
        $this->view("karyawan.home", $data);
    }

    public function getCurrentKaryawan()
    {
        if (!isset($_SESSION["username"])) {
            throw new \RuntimeException("User not authenticated");
        }

        $karyawan = $this->karyawanModel->findByNik($_SESSION["username"]);
        return $karyawan;
    }

    public function absensiBulanan()
    {
        $karyawan = $this->getCurrentKaryawan();

        $id = $karyawan->id;
        $periode = $_GET["periode"];

        $data = $this->absensiUtil->getDataAbsensiBulanan($id, $periode);

        $this->view("features.absensiBulanan", $data);
    }

    public function generateQrCodeProcess()
    {
        // Baca JSON input
        $data = json_decode(file_get_contents("php://input"), true);
        $nik = $data["nik"] ?? "";

        // Validasi NIK
        if (empty($nik)) {
            throw new \Exception("NIK tidak boleh kosong");
        }

        header("Content-Type: image/png");

        $qrString = generateQrCodeString($nik);

        echo $qrString;
    }

    public function detailGajiKaryawan()
    {
        $karyawan = $this->getCurrentKaryawan();

        $dataGajiKaryawan = $this->gajiModel->findByKaryawanId($karyawan->id);
        $this->view("karyawan.features.detailGajiKaryawan", [
          "dataGajiKaryawan" => $dataGajiKaryawan,
          "idKaryawan" => $karyawan->id,
          "namaKaryawan" => $karyawan->nama,
          "page" => "Gaji Karyawan",
          "subpage" => "Laporan Gaji Karyawan",
        ]);
    }

    public function updatePassword()
    {
        $newPassword = $_POST["newPassword"];
        $confirmNewPassword = $_POST["confirmNewPassword"];

        $karyawan = $this->getCurrentKaryawan();
        $data = ["page" => "Profile", "karyawan" => $karyawan];

        if (
            isset($newPassword) &&
            $newPassword !== "" &&
            isset($confirmNewPassword) &&
            $confirmNewPassword !== ""
        ) {
            if ($newPassword === $confirmNewPassword) {
                $this->userModel->update($_SESSION["user_id"], [
                  "password" => password_hash($newPassword, PASSWORD_DEFAULT),
                ]);
                $data["message"] = "Password berhasil diganti";
            } else {
                $data["message"] = "Password tidak sama";
            }
        } else {
            $data["message"] = "Password tidak boleh kosong";
        }

        $this->view("karyawan.profile", $data);
    }

    public function profile()
    {
        $karyawan = $this->getCurrentKaryawan();

        $this->view("karyawan.profile", [
          "page" => "Profile",
          "karyawan" => $karyawan,
        ]);
    }

    public function cetakSlipGajiOne()
    {
        $id = $_POST["gaji_id"];

        $karyawan = $this->gajiModel->findById($id);

        $this->view("slipGajiOne", ["karyawan" => $karyawan]);
    }

    public function cetakSlipGajiAll()
    {
        $periode = $_GET["periode"];

        if (!isset($periode) || $periode === "") {
            $periode = date("Y-m");
        }

        $karyawan_list = $this->gajiModel->findByPeriode($periode);

        $data = [
          "karyawan_list" => $karyawan_list,
        ];

        $this->view("slipGajiAll", $data);
    }
}
