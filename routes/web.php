<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/sistemas', [HomeController::class, 'systems'])->name('sistemas');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Rutas para Catalogo de Invitaciones
Route::prefix('disenos-invitaciones')->group(function () {
    Route::get('/', [App\Http\Controllers\CatalogoInvitacionesController::class, 'index'])->name('catalogo.index');
    Route::get('/{categoria}', [App\Http\Controllers\CatalogoInvitacionesController::class, 'show'])->name('catalogo.show');
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
