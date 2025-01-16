<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use App\Core\Router;
use eftec\bladeone\BladeOne;

// Inisialisasi BladeOne
$views =  __DIR__ . '/../resources/views';
$cache =  __DIR__ . '/../storage/cache';

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$router = new Router($blade);

// load all route files
$routeFiles = [
  '../app/routes/hrd.php',
  '../app/routes/keuangan.php',
  '../app/routes/pimpinan.php',
  '../app/routes/auth.php',
];

foreach($routeFiles as $file) {
  $routeCallback = require $file;
  $routeCallback($router);
}

// get current request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $path = rtrim($path, '/')  // Hapus trailing slash kecuali jika hanya '/'

try {
  $router->dispatch($method, $path);
} catch(\Exception $e) {
  // echo $blade->run('errors.404');
  echo $e;
}
