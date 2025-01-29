<?php

return function ($router) {

    $router->group('/karyawan', ['Auth', 'KaryawanAccess'], function ($router) {
        $controller = '\App\Controllers\KaryawanController';

        $router->get('', $controller, 'profile');
        $router->get('/', $controller, 'profile');

        $router->get('/absensi/detail', $controller, 'absensiBulanan');
        $router->get('/profile', $controller, 'profile');
        $router->post('/profile/update-password', $controller, 'updatePassword');

        $router->get('/gaji-karyawan/detail', $controller, 'detailGajiKaryawan');

        $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
        $router->get('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');

        $router->post('/generate-qrcode/generate', $controller, 'generateQrCodeProcess');

    });


};
