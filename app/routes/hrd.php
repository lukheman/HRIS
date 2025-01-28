<?php

return function ($router) {


    $router->group('/hrd', ['Auth', 'HRDAccess'], function ($router) {
        $controller = '\App\Controllers\HrdController';

        $router->get('', $controller, 'index');
        $router->get('/', $controller, 'index');
        $router->get('/karyawan', $controller, 'listKaryawan');

        $router->get('/karyawan/add', $controller, 'addKaryawanForm');
        $router->post('/karyawan/add', $controller, 'createKaryawan');

        $router->get('/karyawan/update', $controller, 'updateKaryawanForm');
        $router->post('/karyawan/update', $controller, 'updateKaryawan');
        $router->post('/karyawan/delete', $controller, 'deleteKaryawan');

        $router->get('/gaji-karyawan', $controller, 'selectKaryawanGaji');
        $router->get('/gaji-karyawan/detail', $controller, 'detailGajiKaryawan');
        $router->post('/gaji-karyawan/add', $controller, 'addGajiKaryawan');
        $router->post('/gaji-karyawan/delete', $controller, 'deleteGajiKaryawan');

        $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
        $router->get('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');

        $router->get('/absensi/detail', $controller, 'absensiBulanan');
        $router->get('/absensi/all', $controller, 'listAbsensi');
        $router->post('/absensi/update', $controller, 'updateAbsensi');

        $router->get('/absensi/scan-qrcode', $controller, 'scanQrCode');
        $router->get('/absensi/generate-qrcode', $controller, 'generateQrCode');
        $router->get('/absensi/generate-qrcode/search', $controller, 'generateQrCode');
        $router->post('/absensi/generate-qrcode/generate', $controller, 'generateQrCodeProcess');
        $router->post('/absensi/generate-qrcode/save', $controller, 'saveQrCode');

        $router->post('/absensi/process-scan', $controller, 'processScan');


    });

};
