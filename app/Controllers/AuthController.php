<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends Controller
{
    private $userModel;


    public function __construct($blade)
    {
        parent::__construct($blade);
        $this->userModel = new UserModel();
    }

    public function showLogin()
    {
        echo $this->blade->run('login');
    }

    public function handleLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';


        $user = $this->userModel->findByUsername($username);

        if($user && (password_verify($password, $user->password))) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['name'] = $user->name;

            // Berdasarkan role, arahkan ke halaman yang sesuai
            switch ($user->role) {
                case 'HRD':
                    header("Location: {$_ENV['BASE_URL']}/hrd");
                    break;
                case 'KEUANGAN':
                    header("Location: {$_ENV['BASE_URL']}/keuangan");
                    break;
                case 'PIMPINAN':
                    header("Location: {$_ENV['BASE_URL']}/pimpinan");
                    break;
                case 'KARYAWAN':
                    header("Location: {$_ENV['BASE_URL']}/karyawan");
                    break;
                default:
                    echo "Role tidak valid";
            }
            exit();
        } else {
            echo $this->blade->run('login', ['error' => 'Password atau Username salah']);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['name']);
        header("Location: {$_ENV['BASE_URL']}/login");
        exit();
    }

}
