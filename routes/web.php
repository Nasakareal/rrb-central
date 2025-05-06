<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/sistemas', [HomeController::class, 'systems'])->name('sistemas');
Route::get('/about', [HomeController::class, 'about'])->name('about');
