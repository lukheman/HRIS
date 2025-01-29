<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Core\Router;
use eftec\bladeone\BladeOne;
use Symfony\Component\Dotenv\Dotenv;


// inisialisali dotenv

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Mengatur zona waktu ke Indosia Tengan (WITA)
date_default_timezone_set('Asia/Makassar');

// Inisialisasi BladeOne
$views =  __DIR__ . '/resources/views';
$cache =  __DIR__ . '/storage/cache';

if (!is_dir($cache)) {
    mkdir($cache, 0777, true);  // 0777 untuk izin penuh, true untuk membuat subdirektori jika diperlukan
}

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

// fungsi custom
$blade->directive('base_url', function ($url) {
  return $_ENV['BASE_URL'] . $url;
});


$router = new Router($blade);

// load all route files
$routeFiles = [
  './app/routes/auth.php',
  './app/routes/hrd.php',
  './app/routes/keuangan.php',
  './app/routes/pimpinan.php',
  './app/routes/karyawan.php',
];


foreach($routeFiles as $file) {
  $routeCallback = require $file;
  $routeCallback($router);
}

// get current request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


try {
  $router->dispatch($method, $path);
} catch(\Exception $e) {
  // echo $blade->run('errors.404');
  echo $e;
}
