<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogoInvitacionesController extends Controller
{
    public function index()
    {
        $categorias = [
            'xv' => [
                'nombre' => 'XV Años',
                'imagen' => 'xv.png'
            ],
            'boda' => [
                'nombre' => 'Bodas',
                'imagen' => 'boda.png'
            ],
            'cumple' => [
                'nombre' => 'Cumpleaños',
                'imagen' => 'cumple.png'
            ],
            'convivio' => [
                'nombre' => 'Convivios',
                'imagen' => 'convivio.png'
            ],
            'graduacion' => [
                'nombre' => 'Graduaciones',
                'imagen' => 'graduacion.png'
            ],
        ];

        return view('invitaciones.catalogo.index', compact('categorias'));
    }

    public function show($categoria)
    {
        $categorias = [
            'xv' => 'XV Años',
            'boda' => 'Bodas',
            'cumple' => 'Cumpleaños',
            'convivio' => 'Convivios',
            'graduacion' => 'Graduaciones'
        ];

        abort_unless(array_key_exists($categoria, $categorias), 404);

        $nombreCategoria = $categorias[$categoria];
        return view('invitaciones.catalogo.show', compact('categoria', 'nombreCategoria'));
    }
}
