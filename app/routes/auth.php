<?php

return function ($router) {

    $router->get('/', '\App\Controllers\HomeController', 'index');
    $router->get('/absensi/scan', '\App\Controllers\HomeController', 'scanQrCode');
    $router->post('/absensi/process-scan', '\App\Controllers\HomeController', 'processScan');
    $router->get('/login', '\App\Controllers\AuthController', 'showLogin');
    $router->post('/login', '\App\Controllers\AuthController', 'handleLogin');
    $router->get('/logout', '\App\Controllers\AuthController', 'logout');

};
