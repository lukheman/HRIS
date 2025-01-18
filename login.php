<?php

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use eftec\bladeone\BladeOne;
use App\Models\UserModel;

include('includes/db.php');

// Inisialisasi BladeOne
$views =  __DIR__ . '/../resources/views';
$cache =  __DIR__ . '/../storage/cache';

$userModel = new UserModel();

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari pengguna berdasarkan username
    $user = UserModel->findByUsername($username);

    // Verifikasi password menggunakan password_verify
    // TODO: ubah hash dan jangan gunakan md5

    if ($user && (md5($password) === $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        // Berdasarkan role, arahkan ke halaman yang sesuai
        switch ($user['role']) {
            case 'HRD':
              header('Location: index.php?page=hrd');
                break;
            case 'KEUANGAN':
              header('Location: index.php?page=keuangan_home');
                break;
            case 'PIMPINAN':
              header('Location: index.php?page=pimpinan_home');
                break;
            default:
                echo "Role tidak valid";
        }
        exit();
    } else {
        echo "Username atau password salah";
    }
}
// Menampilkan halaman login jika bukan POST
  echo $blade->run('login');
?>
