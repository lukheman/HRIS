<?php

namespace App\Models;

use App\Core\Model;


class UserModel extends Model {

  protected $table = 'tb_users';

  // method kusus untuk user
  public function findByUsername($username) {
    $sql = "SELECT * FROM {$this->table} WHERE username = ?";
    return $this->query($sql, [$username])->fetch();
  }

}
