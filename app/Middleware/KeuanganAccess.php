<?php

namespace App\Middleware;

class KeuanganAccess {
  public function handle() {
    return $_SESSION['user_role'] === 'KEUANGAN';
  }
}
