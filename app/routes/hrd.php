<?php

return function ($router) {

    $router->group('/hrd', ['Auth', 'HRDAccess'], function ($router) {
        $controller = '\App\Controllers\HrdController';

        // Route untuk halaman utama HRD
        $router->get('', $controller, 'index');
        $router->get('/', $controller, 'index');

        // route untuk manajemen karyawan
        $router->get('/karyawan', $controller, 'listKaryawan');
        $router->get('/karyawan/add', $controller, 'addKaryawanForm');
        $router->post('/karyawan/add', $controller, 'createKaryawan');
        $router->get('/karyawan/update', $controller, 'updateKaryawanForm');
        $router->post('/karyawan/update', $controller, 'updateKaryawan');
        $router->post('/karyawan/delete', $controller, 'deleteKaryawan');

        // route untuk managemen gaji karyawan
        $router->get('/gaji-karyawan', $controller, 'selectKaryawanGaji');
        $router->get('/gaji-karyawan/detail', $controller, 'detailGajiKaryawan');
        $router->post('/gaji-karyawan/add', $controller, 'addGajiKaryawan');
        $router->post('/gaji-karyawan/delete', $controller, 'deleteGajiKaryawan');


        $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
        $router->post('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');
        $router->post('/gaji-karyawan/cetak-laporan-gaji', $controller, 'cetakLaporanGaji');
        $router->post('/gaji-karyawan/update', $controller, 'updateGajiKaryawan');

        // route untuk absensi
        $router->get('/absensi/detail', $controller, 'absensiBulanan');
        $router->get('/absensi/all', $controller, 'listAbsensi');
        $router->post('/absensi/update', $controller, 'updateAbsensi');
        $router->post('/absensi/cetak-laporan-absensi', $controller, 'cetakLaporanAbsensi');

        // route untuk qrcode
        $router->get('/absensi/scan-qrcode', $controller, 'scanQrCode');
        $router->get('/absensi/generate-qrcode', $controller, 'generateQrCode');
        $router->get('/absensi/generate-qrcode/search', $controller, 'generateQrCode');
        $router->post('/absensi/generate-qrcode/generate', $controller, 'generateQrCodeProcess');
        $router->post('/absensi/generate-qrcode/save', $controller, 'saveQrCode');

        $router->post('/absensi/process-scan', $controller, 'processScan');


    });

};
