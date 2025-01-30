<?php

namespace App\Controllers\Api;

use App\Models\KaryawanModel;

class KaryawanApiController {
  private $karyawanModel;

  public function __construct() {
    $this->karyawanModel = new KaryawanModel();
  }

  public function getKaryawanAll() {
    header('Content-Type: application/json');
    $listKaryawan = $this->karyawanModel->all();
    $response = [
      'status' =>'success',
      'message' => 'successfully retrieved all employee data',
      'data' => $listKaryawan,
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
  }

}
