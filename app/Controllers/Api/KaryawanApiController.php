<?php

namespace App\Controllers\Api;

use App\Models\KaryawanModel;
use App\Models\JabatanModel;

class KaryawanApiController
{
    private $karyawanModel;
    private $jabatanModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->jabatanModel = new JabatanModel();
    }

    public function getKaryawanAll()
    {
        header('Content-Type: application/json');
        $listKaryawan = $this->karyawanModel->all();
        $response = [
          'status' => 'success',
          'message' => 'successfully retrieved all employee data',
          'data' => $listKaryawan,
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function getJabatan()
    {
        header('Content-Type: application/json');
        $data = $this->jabatanModel->all();
        $response = [
          'status' => 'success',
          'message' => 'successfully retrieved all jabatan data',
          'data' => $data,
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

}
