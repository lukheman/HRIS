<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;

class Controller
{
    protected $blade;

    public function __construct(BladeOne $blade)
    {
        $this->blade = $blade;
    }

    public function view($page, $data = null) {

      if (isset($data)) {
        echo $this->blade->run($page, $data);
        exit();
      }

      echo $this->blade->run($page);
      exit();

    }

}
