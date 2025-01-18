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
        echo $this->blade->run('home.index', $data);
    }


    public function about()
    {
        $data = [

          'title' => 'About Page',
          'content' => 'Welcome akmal about',

        ];

        echo $this->blade->run('home.about', $data);

    }

}
