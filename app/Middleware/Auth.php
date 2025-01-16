<?php

namespace App\Middleware;

class Auth {
  public function handle() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['name']);
  }
}
