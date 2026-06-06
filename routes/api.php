<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CategoriaController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get(
    '/me',
    [AuthController::class, 'me']
);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::apiResource('productos', ProductoController::class);
Route::apiResource('categorias', CategoriaController::class);

Route::get(
    'categorias/{categoria}/productos',
    [CategoriaController::class, 'productos']
);

Route::post('/pedidos', PedidoController::class);