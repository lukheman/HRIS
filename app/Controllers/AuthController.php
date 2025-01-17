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
        session_start();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';


        $user = $this->userModel->findByUsername($username);

        if($user && (md5($password) === $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['name'] = $user->name;

            // Berdasarkan role, arahkan ke halaman yang sesuai
            switch ($user->role) {
                case 'HRD':
                    header('Location: /hrd');
                    break;
                case 'KEUANGAN':
                    header('Location: /keuangan');
                    break;
                case 'PIMPINAN':
                    header('Location: /pimpinan');
                    break;
                default:
                    echo "Role tidak valid";
            }
            exit();
        } else {
            $this->blade->run('login', ['error' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['name']);
        header('Location: /login');
        exit();
    }

}
