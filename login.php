<?php
use eftec\bladeone\BladeOne;

session_start();
require_once 'vendor/autoload.php';

include('includes/db.php');

$conn = getDbConnection();

$views = 'pages';
$cache = 'cache';

$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari pengguna berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM tb_users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi password menggunakan password_verify
    // TODO: ubah hash dan jangan gunakan md5
    if ($user && (md5($password) === $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
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
