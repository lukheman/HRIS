<?php
require_once __DIR__ . '/../vendor/autoload.php';
use eftec\bladeone\BladeOne;

// Definisikan konstanta path
define('VIEWS_PATH', __DIR__ . '/../resources/views');
define('CACHE_PATH', __DIR__ . '/../storage/cache');

// Inisialisasi BladeOne
$blade = new BladeOne(VIEWS_PATH, CACHE_PATH, BladeOne::MODE_DEBUG);

// Ambil URI dari request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    '/hrd' => [\App\Controllers\HrdController::class, 'index'],
    '/hrd/karyawan' => [\App\Controllers\HrdController::class, 'karyawan'],
    '/hrd/calendar' => [\App\Controllers\HrdController::class, 'calendar'],
    '/hrd/karyawanAddForm' => [\App\Controllers\HrdController::class, 'karyawanAddForm'],
    '/hrd/karyawanUpdateForm' => [\App\Controllers\HrdController::class, 'karyawanUpdateForm'],
    '/hrd/karyawan/add' => [\App\Controllers\HrdController::class, 'karyawanCreate'],
    '/hrd/karyawan/delete' => [\App\Controllers\HrdController::class, 'karyawanDelete'],
    '/hrd/karyawan/update' => [\App\Controllers\HrdController::class, 'karyawanUpdate'],
    '/hrd/absensiAllShow' => [\App\Controllers\HrdController::class, 'absensiAllShow'],
    '/hrd/absensiBulanan' => [\App\Controllers\HrdController::class, 'absensiBulanan'],

    '/keuangan' => [\App\Controllers\KeuanganController::class, 'index'],
    '/keuangan/gajiKaryawanShow' => [\App\Controllers\KeuanganController::class, 'gajiKaryawanShow'],
    '/keuangan/gajiKaryawan/verifikasiShow' => [\App\Controllers\KeuanganController::class, 'gajiKaryawanVerifikasiShow'],
    '/keuangan/gajiKaryawan/verifikasi' => [\App\Controllers\KeuanganController::class, 'gajiKaryawanVerifikasi'],
    '/keuangan/gajiKaryawan/update' => [\App\Controllers\KeuanganController::class, 'gajiKaryawanUpdate'],
    '/keuangan/cetakSlipGajiOne' => [\App\Controllers\KeuanganController::class, 'cetakSlipGajiOne'],
    '/keuangan/cetakSlipGajiAll' => [\App\Controllers\KeuanganController::class, 'cetakSlipGajiAll'],
];

if (array_key_exists($uri, $routes)) {
  [$controllerClass, $method] = $routes[$uri];
  $controller = new $controllerClass($blade);

  if (method_exists($controller, $method)) {
    $controller->$method();
  } else {
    http_response_code(404);
    echo "method not found";
  }
}

/*// Routing sederhana*/
/*switch($uri) {*/
/*    case '/':*/
/*        $controller = new \App\Controllers\HomeController($blade);*/
/*        $controller->index();*/
/*        break;*/
/*    case '/about':*/
/*        $controller = new \App\Controllers\HomeController($blade);*/
/*        $controller->about();*/
/*        break;*/
/*    case '/hrd':*/
/*        $controller = new \App\Controllers\HrdController($blade);*/
/*        $controller->index();*/
/*        break;*/
/*    case '/hrd/absensi':*/
/*        $controller = new \App\Controllers\HrdController($blade);*/
/*        $controller->index();*/
/*        break;*/
/*    default:*/
/*        echo '404 Not Found';*/
/*        break;*/
/*}*/
