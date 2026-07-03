<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\PoleoCatalogController;
use App\Http\Controllers\Api\PoleoImportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('poleos.token')->prefix('poleos')->group(function () {
    Route::get('/ping', function () {
        return response()->json([
            'message' => 'OK',
            'data' => [
                'servicio' => 'poleos',
            ],
        ]);
    });

    Route::post('/importar', [PoleoImportController::class, 'store']);
    Route::get('/catalogos', [PoleoCatalogController::class, 'index']);
    Route::post('/campus', [PoleoCatalogController::class, 'storeCampus']);
    Route::post('/departamentos', [PoleoCatalogController::class, 'storeDepartamento']);
    Route::post('/puestos', [PoleoCatalogController::class, 'storePuesto']);
    Route::post('/horarios', [PoleoCatalogController::class, 'storeHorario']);
    Route::get('/empleados', [EmpleadoController::class, 'index']);
    Route::post('/empleados', [EmpleadoController::class, 'store']);
    Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show']);
    Route::put('/empleados/{empleado}', [EmpleadoController::class, 'update']);
    Route::post('/empleados/{empleado}/horarios', [EmpleadoController::class, 'asignarHorario']);
});
