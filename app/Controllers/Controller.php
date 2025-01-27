<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;

class Controller
{
    protected $blade;
    protected $role;

    public function __construct(BladeOne $blade, $role = null)
    {
        $this->blade = $blade;
        $this->role = $role;
    }

    public function view($page, $data = null)
    {

        if (isset($data)) {
            $data['role'] = $this->role;
            echo $this->blade->run($page, $data);
            exit();
        }

        echo $this->blade->run($page);
        exit();

    }

}
