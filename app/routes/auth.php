<?php

return function ($router) {

    $router->get('/', '\App\Controllers\AuthController', 'showLogin');
    $router->get('/login', '\App\Controllers\AuthController', 'showLogin');
    $router->post('/login', '\App\Controllers\AuthController', 'handleLogin');
    $router->get('/logout', '\App\Controllers\AuthController', 'logout');

};
