<?php

return function ($router) {


  $router->group('/hrd', ['Auth', 'HRDAccess'], function($router) {
    $controller = '\App\Controllers\HrdController';

    $router->get('', $controller, 'index');
    $router->get('/karyawan', $controller, 'listKaryawan');

    $router->get('/karyawan/add', $controller, 'addKaryawanForm');
    $router->post('/karyawan/add', $controller, 'createKaryawan');

    $router->get('/karyawan/update', $controller, 'updateKaryawanForm');
    $router->post('/karyawan/update', $controller, 'updateKaryawan');
    $router->post('/karyawan/delete', $controller, 'deleteKaryawan');

    $router->get('/absensi/detail', $controller, 'absensiBulanan');
    $router->get('/absensi/all', $controller, 'listAbsensi');

    $router->get('/absensi/scan-qrcode', $controller, 'scanQrCode');
    $router->get('/absensi/generate-qrcode', $controller, 'generateQrCode');
    $router->get('/absensi/generate-qrcode/search', $controller, 'generateQrCode');
    $router->post('/absensi/generate-qrcode/generate', $controller, 'generateQrCodeProcess');
  });

};
