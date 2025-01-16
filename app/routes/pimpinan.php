<?php

return function ($router) {
  $router->group('/pimpinan', ['Auth', 'PimpinanAccess'], function($router) {
    $controller = '\App\Controllers\PimpinanController';

    $router->get('', $controller, 'index');
    $router->get('/gaji-karyawan', $controller, 'listGajiKaryawan');

    $router->post('/gaji-karyawan/cetak-slip-gaji', $controller, 'cetakSlipGajiOne');
    $router->get('/gaji-karyawan/cetak-slip-gaji-all', $controller, 'cetakSlipGajiAll');

    $router->get('/absensi/detail', $controller, 'absensiBulanan');
    $router->get('/absensi/all', $controller, 'listAbsensi');

  });
};
