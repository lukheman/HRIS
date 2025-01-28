<?php

namespace App\Middleware;

class KaryawanAccess
{
    public function handle()
    {
        return $_SESSION['user_role'] === 'KARYAWAN';
    }
}
