<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class CatalogoCartasController extends Controller
{
    public function index()
    {
        $categorias = [
            'romanticas' => [
                'nombre' => 'Románticas',
                'imagen' => 'dinner.png'
            ],
            'agradecimiento' => [
                'nombre' => 'Agradecimiento',
                'imagen' => 'gratitude.png'
            ],
            'motivacion' => [
                'nombre' => 'Motivación',
                'imagen' => 'motivation.png'
            ],
        ];

        return view('cartas.index', compact('categorias'));
    }

    public function show($categoria)
    {
        // Nombres bonitos
        $diccionario = [
            'romanticas'     => 'Románticas',
            'agradecimiento' => 'Agradecimiento',
            'motivacion'     => 'Motivación',
        ];

        // Si no existe la categoría, 404
        abort_unless(array_key_exists($categoria, $diccionario), 404);
        $nombreCategoria = $diccionario[$categoria];

        // Ruta donde están las plantillas blade de esa categoría
        $vistaPath = resource_path("views/cartas/plantillas/{$categoria}");
        $plantillas = [];

        if (File::exists($vistaPath)) {
            foreach (File::files($vistaPath) as $archivo) {
                if ($archivo->getExtension() === 'php') {
                    $nombreArchivo = str_replace('.blade.php', '', $archivo->getFilename());
                    $plantillas[] = [
                        'nombre'         => ucfirst(str_replace('_', ' ', $nombreArchivo)),
                        'nombre_archivo' => $nombreArchivo,
                        'ruta'           => route('cartas.ver', [$categoria, $nombreArchivo]),
                    ];
                }
            }
        }

        return view('cartas.categoria', compact(
            'categoria',
            'nombreCategoria',
            'plantillas'
        ));
    }

    public function verCarta($categoria, $plantilla)
    {
        $vista = "cartas.plantillas.{$categoria}.{$plantilla}";
        abort_unless(view()->exists($vista), 404);
        return view($vista);
    }
}
