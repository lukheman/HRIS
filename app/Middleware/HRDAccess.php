<?php

namespace App\Middleware;

class HRDAccess {
  public function handle() {
    return $_SESSION['user_role'] === 'HRD';
  }
}
