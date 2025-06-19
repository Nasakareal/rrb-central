<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitacion;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

class QrController extends Controller
{
    public function mostrarQr($token)
    {
        $invitacion = Invitacion::with('user')->where('qr_token', $token)->firstOrFail();

        $textoQr = "Invitado: {$invitacion->user->name}\n"
                 . "Pases: {$invitacion->num_pases_confirmados}\n"
                 . "Token: {$invitacion->qr_token}";

        $qr = Builder::create()
            ->writer(new PngWriter())
            ->data($textoQr)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->build();

        return response($qr->getString())
            ->header('Content-Type', $qr->getMimeType());
    }
}
