<?php

return function ($router) {
    $router->group('/api', ['Auth'], function ($router) {
        $karyawanApiController = '\App\Controllers\Api\KaryawanApiController';

        $router->get('/get-karyawan-all', $karyawanApiController, 'getKaryawanAll');
    });
};
