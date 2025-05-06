<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // Método para la ruta raíz
    public function index()
    {
        return view('welcome');
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function systems()
    {
        return view('systems');
    }

    public function about()
    {
        return view('about');
    }
}
