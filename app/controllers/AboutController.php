<?php

namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $this->view('about/index', [
            'title'    => 'About Us',
            'activeNav' => 'about',
        ]);
    }
}
