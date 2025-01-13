<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;

class Controller {

  protected $blade;

  public function __construct(BladeOne $blade) {
    $this->blade = $blade;
  }

}
