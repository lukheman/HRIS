<?php

return function ($router) {
    $router->group('/keuangan', ['Auth', 'KeuanganAccess'], function ($router) {
        $controller = '\App\Controllers\KeuanganController';

        $router->get('', $controller, 'index');
        $router->get('/', $controller, 'index');

        // $router->get('/gaji-karyawan', $controller, 'listGajiKaryawan');

        $router->get('/gaji-karyawan', $controller, 'selectKaryawanGaji');
        $router->get('/gaji-karyawan/detail', $controller, 'detailGajiKaryawan');
        $router->post('/gaji-karyawan/add', $controller, 'addGajiKaryawan');
        $router->post('/gaji-karyawan/delete', $controller, 'deleteGajiKaryawan');
        $router->post('/gaji-karyawan/approve', $controller, 'approveGajiKaryawan');
        $router->post('/gaji-karyawan/pending', $controller, 'pendingGajiKaryawan');
        $router->post('/gaji-karyawan/approve-selected', $controller, 'approveSelectedGajiKaryawan');
        $router->post('/gaji-karyawan/pending-selected', $controller, 'pendingSelectedGajiKaryawan');
        $router->post('/gaji-karyawan/update', $controller, 'updateGajiKaryawan');

        $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
        $router->get('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');
        $router->post('/gaji-karyawan/cetak-laporan-gaji', $controller, 'cetakLaporanGaji');

        $router->get('/absensi/detail', $controller, 'absensiBulanan');
        $router->get('/absensi/all', $controller, 'listAbsensi');
        $router->post('/absensi/update', $controller, 'updateAbsensi');
        $router->post('/absensi/cetak-laporan-absensi', $controller, 'cetakLaporanAbsensi');

    });

};
