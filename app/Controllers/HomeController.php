<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'IAstroMatch — Institut d\'Harmonisation Relationnelle',
            'hideHeader' => true,
            'hideIA' => true
        ];
        
        $this->view('home/intro', $data);
    }
}

