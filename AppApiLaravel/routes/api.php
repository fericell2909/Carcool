<?php

use Illuminate\Http\Request;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API para Registrar Usuarios.
Route::post('register', 'API\RegisterController@register');



// Rutas Con Autenticacion.
Route::middleware('auth:api')->group( function () {
    
    // Mostrar Jugador x ID
    Route::get('mostrarjugador/{id?}', 'API\PlayerController@show');

    // Guardar Jugador.
    Route::post('registrarjugador', 'API\PlayerController@save');

    // Mostar Equipos de ha jugado
    Route::get('listarequipos/{id?}', 'API\PlayerController@shows_clubes_by_team');

});


