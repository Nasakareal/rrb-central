<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CentaurosController extends Controller
{
    /**
     * Página principal de Centauros (galería + botón intercambio).
     */
    public function index()
    {
        $fotos = [
            '1.jpg',
            '2.jpg',
            '3.jpg',
            '4.jpg',
        ];

        return view('centauros.index', compact('fotos'));
    }

    private function participantes()
    {
        return [
            'centauro01' => [
                'password' => 'clave01',
                'nombre'   => 'OF. JUAN PÉREZ',
                'asignado' => 'OF. LUIS RAMÍREZ',
            ],
            'centauro02' => [
                'password' => 'clave02',
                'nombre'   => 'OF. ANA LÓPEZ',
                'asignado' => 'OF. CARLOS HERNÁNDEZ',
            ],
            'centauro03' => [
                'password' => 'clave03',
                'nombre'   => 'OF. MARIO B.',
                'asignado' => 'OF. FERNANDA GARCÍA',
            ],

        ];
    }

    /**
     * Muestra el formulario de login del intercambio.
     */
    public function showIntercambioForm()
    {
        return view('centauros.intercambio');
    }

    /**
     * Procesa el login y muestra el resultado del intercambio.
     */
    public function procesarIntercambio(Request $request)
    {
        $request->validate([
            'usuario'  => 'required',
            'password' => 'required',
        ], [
            'usuario.required'  => 'Pon tu usuario, centauro.',
            'password.required' => 'Falta la contraseña.',
        ]);

        $usuarioInput = strtolower(trim($request->input('usuario')));
        $passwordInput = $request->input('password');

        $participantes = $this->participantes();

        if (!isset($participantes[$usuarioInput])) {
            return back()
                ->withErrors(['usuario' => 'Usuario o contraseña incorrectos.'])
                ->withInput();
        }

        $datos = $participantes[$usuarioInput];

        if ($datos['password'] !== $passwordInput) {
            return back()
                ->withErrors(['usuario' => 'Usuario o contraseña incorrectos.'])
                ->withInput();
        }

        return view('centauros.intercambio', [
            'datos' => $datos,
        ]);
    }
}
