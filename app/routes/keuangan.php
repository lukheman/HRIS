<?php

return function ($router) {
    $router->group('/keuangan', ['Auth', 'KeuanganAccess'], function ($router) {
        $controller = '\App\Controllers\KeuanganController';

        $router->get('', $controller, 'index');
        $router->get('/gaji-karyawan', $controller, 'listGajiKaryawan');
        $router->get('/gaji-karyawan/update', $controller, 'updateGajiKaryawan');

        $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
        $router->get('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');

    });

};
