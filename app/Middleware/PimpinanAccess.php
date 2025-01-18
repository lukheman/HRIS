<?php

namespace App\Middleware;

class PimpinanAccess
{
    public function handle()
    {
        return $_SESSION['user_role'] === 'PIMPINAN';
    }
}
