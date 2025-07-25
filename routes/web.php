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

Route::get('/camila/confirmados', function () {
    $evento = \App\Models\Evento::where('codigo_unico', 'camila')->firstOrFail();
    $confirmaciones = \App\Models\Confirmacion::where('evento_id', $evento->id)->latest()->get();
    return view('invitaciones.Camila.confirmados', compact('confirmaciones'));
})->name('camila.confirmados');

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


// Módulo Papelería “La Manzana”
Route::prefix('la-manzana')->name('papeleria.')->group(function () {
    // 1) Página principal y catálogo (público)
    Route::get('/',                                [App\Http\Controllers\Papeleria\PapeleriaController::class, 'index'])->name('index');
    Route::get('/categorias',                      [App\Http\Controllers\Papeleria\CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/productos',                       [App\Http\Controllers\Papeleria\ProductoController::class, 'index'])->name('productos.index');

    // 2) Carrito de compras (cliente sin login)
    Route::get('/carrito',                         [App\Http\Controllers\Papeleria\CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add/{producto}',         [App\Http\Controllers\Papeleria\CarritoController::class, 'add'])->name('carrito.add');
    Route::post('/carrito/remove/{producto}',      [App\Http\Controllers\Papeleria\CarritoController::class, 'remove'])->name('carrito.remove');
    Route::post('/carrito/confirm',                [App\Http\Controllers\Papeleria\CarritoController::class, 'confirm'])->name('carrito.confirm');

    // 3) Administración (requiere login)
    Route::middleware('auth')->group(function () {
        // Categorías
        Route::get('/categorias/create',                  [App\Http\Controllers\Papeleria\CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('/categorias',                        [App\Http\Controllers\Papeleria\CategoriaController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}/edit',        [App\Http\Controllers\Papeleria\CategoriaController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{categoria}',             [App\Http\Controllers\Papeleria\CategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{categoria}',          [App\Http\Controllers\Papeleria\CategoriaController::class, 'destroy'])->name('categorias.destroy');

        // Productos
        Route::get('/productos/create',                   [App\Http\Controllers\Papeleria\ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos',                         [App\Http\Controllers\Papeleria\ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/{producto}/edit',          [App\Http\Controllers\Papeleria\ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{producto}',               [App\Http\Controllers\Papeleria\ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{producto}',            [App\Http\Controllers\Papeleria\ProductoController::class, 'destroy'])->name('productos.destroy');
    });

    // 4) Mostrar categoría y producto individual (deben ir al final)
    Route::get('/categorias/{categoria}',          [App\Http\Controllers\Papeleria\CategoriaController::class, 'show'])->name('categorias.show');
    Route::get('/productos/{producto}',            [App\Http\Controllers\Papeleria\ProductoController::class, 'show'])->name('productos.show');
});


Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});


require __DIR__.'/auth.php';
