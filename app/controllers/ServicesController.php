<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $this->view('services/index', [
            'title'    => 'Our Services',
            'activeNav' => 'services',
            'services' => (new Service())->active(),
        ]);
    }
}
