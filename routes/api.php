<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthSanctumController;
use App\Http\Controllers\UsersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/Get_Token', [AuthSanctumController::class, 'token']);

Route::prefix('prueba')->middleware(['auth:sanctum'])->group(function () {

    // Ruta para crear usuarios nuevos
    Route::post('/Create_User', [UsersController::class, 'crearUsuario']);
    // Ruta para actualizar usuario
    Route::put('/Update_User', [UsersController::class, 'actualizarUsuario']);
    // Ruta para eliminar usuario
    Route::delete('/Delete_User', [UsersController::class, 'eliminarUsuario']);
});
