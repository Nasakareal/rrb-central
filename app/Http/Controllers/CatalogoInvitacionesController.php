<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class CatalogoInvitacionesController extends Controller
{
    public function index()
    {
        $categorias = [
            'xv'          => ['nombre' => 'XV Años',        'imagen' => 'xv.png'],
            'boda'        => ['nombre' => 'Bodas',          'imagen' => 'boda.png'],
            'cumple'      => ['nombre' => 'Cumpleaños',     'imagen' => 'cumple.png'],
            'convivios'    => ['nombre' => 'Convivios',      'imagen' => 'convivio.png'],
            'graduacion'  => ['nombre' => 'Graduaciones',   'imagen' => 'graduacion.png'],
        ];

        return view('invitaciones.catalogo.index', compact('categorias'));
    }

    public function show($categoria)
    {
        // nombres legibles de categoría
        $diccionario = [
            'xv'         => 'XV Años',
            'boda'       => 'Bodas',
            'cumple'     => 'Cumpleaños',
            'convivios'   => 'Convivios',
            'graduacion' => 'Graduaciones',
        ];

        abort_unless(array_key_exists($categoria, $diccionario), 404);
        $nombreCategoria = $diccionario[$categoria];

        // Carpeta de plantillas blade
        $vistaPath = resource_path("views/plantillas/{$categoria}");
        $plantillas = [];

        if (File::exists($vistaPath)) {
            foreach (File::files($vistaPath) as $archivo) {
                if ($archivo->getExtension() === 'php') {
                    // quitar ".blade.php"
                    $nombreArchivo = str_replace('.blade.php', '', $archivo->getFilename());
                    $plantillas[] = [
                        'nombre'         => ucfirst(str_replace('_', ' ', $nombreArchivo)),
                        'nombre_archivo' => $nombreArchivo,
                        'ruta'           => route('plantilla.ver', [$categoria, $nombreArchivo]),
                    ];
                }
            }
        }

        return view('invitaciones.catalogo.show', compact(
            'categoria',
            'nombreCategoria',
            'plantillas'
        ));
    }

    public function verPlantilla($categoria, $plantilla)
    {
        $vista = "plantillas.{$categoria}.{$plantilla}";
        abort_unless(view()->exists($vista), 404);
        return view($vista);
    }
}
