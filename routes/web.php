<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/sistemas', [App\Http\Controllers\HomeController::class, 'systems'])->name('sistemas');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

// Vista fija: /camila
Route::get('/camila', [App\Http\Controllers\InvitacionRealController::class, 'show'])->name('camila.invitacion');
Route::post('/camila/login', [App\Http\Controllers\InvitacionRealController::class, 'login'])->name('camila.login');
Route::post('/camila/{id}/confirmar', [App\Http\Controllers\InvitacionRealController::class, 'confirmar'])->name('camila.confirmacion');
Route::post('/camila/logout', [App\Http\Controllers\InvitacionRealController::class, 'logout'])->name('camila.logout');
Route::post('/camila/foto', [App\Http\Controllers\FotoEventoController::class, 'store'])->name('camila.foto.subir');

Route::get('/camila/fotos', function () {
    $evento = \App\Models\Evento::where('codigo_unico', 'camila')->firstOrFail();
    return view('invitaciones.Camila.galeria', compact('evento'));
})->name('camila.galeria');

Route::get('/camila/qr/{token}', [App\Http\Controllers\QrController::class, 'mostrarQr'])->name('camila.qr');


// Vista pública de Cartas Digitales
Route::prefix('disenos-cartas')->group(function () {
    Route::get('/', [App\Http\Controllers\CatalogoCartasController::class, 'index'])->name('cartas.index');
    Route::get('/{categoria}', [App\Http\Controllers\CatalogoCartasController::class, 'show'])->name('cartas.show');
    Route::get('/{categoria}/{plantilla}', [App\Http\Controllers\CatalogoCartasController::class, 'verCarta'])->name('cartas.ver');
});


// Vista de cada plantilla individual
Route::prefix('disenos-invitaciones')->group(function () {
    Route::get('/', [App\Http\Controllers\CatalogoInvitacionesController::class, 'index'])->name('catalogo.index');
    Route::get('/{categoria}', [App\Http\Controllers\CatalogoInvitacionesController::class, 'show'])->name('catalogo.show');
    Route::get('/{categoria}/{plantilla}', [App\Http\Controllers\CatalogoInvitacionesController::class, 'verPlantilla'])->name('plantilla.ver');
});



// Rutas para Invitaciones
Route::prefix('invitaciones')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\InvitacionController::class, 'index'])->name('invitaciones.index');
    Route::get('/create', [App\Http\Controllers\InvitacionController::class, 'create'])->middleware('can:crear invitaciones')->name('invitaciones.create');
    Route::post('/', [App\Http\Controllers\InvitacionController::class, 'store'])->middleware('can:crear invitaciones')->name('invitaciones.store');
    Route::get('/{invitacion}', [App\Http\Controllers\InvitacionController::class, 'show'])->middleware('can:ver invitaciones')->name('invitaciones.show');
    Route::get('/{invitacion}/edit', [App\Http\Controllers\InvitacionController::class, 'edit'])->middleware('can:editar invitaciones')->name('invitaciones.edit');
    Route::put('/{invitacion}', [App\Http\Controllers\InvitacionController::class, 'update'])->middleware('can:editar invitaciones')->name('invitaciones.update');
    Route::delete('/{invitacion}', [App\Http\Controllers\InvitacionController::class, 'destroy'])->middleware('can:eliminar invitaciones')->name('invitaciones.destroy');
});
