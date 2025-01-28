<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $data = [

          'title' => 'Home Page',
          'content' => 'Welcome akmal ti website ku',

        ];
        echo $this->blade->run('home', $data);
    }


}
