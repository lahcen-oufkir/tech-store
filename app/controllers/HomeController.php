<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home/index', [
            'title'    => 'Home',
            'activeNav' => 'home',
            'featured' => (new Product())->featured(),
            'services' => (new Service())->active(),
        ]);
    }
}
