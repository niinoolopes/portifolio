<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ClienteController
};

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     die('aa');
//     return $request->user();
// });

Route::get('db', 'JobDadaBase@index');

Route::post('login', 'UsuarioController@login');

// Route::get('cliente/{id?}', 'ClienteController@index');
// Route::post('cliente', 'ClienteController@store');
// Route::put('cliente/{id}', 'ClienteController@update');
// Route::delete('cliente/{id}', 'ClienteController@destroy');

// Route::get('motorista/{id?}', 'MotoristaController@index');
// Route::post('motorista', 'MotoristaController@store');
// Route::put('motorista/{id}', 'MotoristaController@update');
// Route::delete('motorista/{id}', 'MotoristaController@destroy');

Route::post('usuario', 'UsuarioController@store');

Route::middleware(['token'])->group(function () {

    Route::get('usuario/list', 'UsuarioController@list');
    Route::get('usuario/customers', 'UsuarioController@customers');
    Route::get('usuario/{id?}', 'UsuarioController@index');
    Route::put('usuario/{id}', 'UsuarioController@update');
    Route::delete('usuario/{id}', 'UsuarioController@destroy');

    Route::get('coleta/status', 'ColetaController@status');
    Route::post('coleta/{id}/accept', 'ColetaController@accept');
    Route::post('coleta/{id}/deliver', 'ColetaController@deliver');
    Route::post('coleta/{id}/delivered', 'ColetaController@delivered');
    Route::post('coleta/{id}/completed', 'ColetaController@completed');
    Route::get('coleta/{id}/sync-price
    ', 'ColetaController@syncPrice');

    Route::get('coleta/{id?}', 'ColetaController@index');
    Route::post('coleta', 'ColetaController@store');
    Route::put('coleta/{id}', 'ColetaController@update');
    Route::delete('coleta/{id}', 'ColetaController@destroy');

    Route::get('coleta/{coleta_id}/product/{item_id?}', 'ColetaProdutoController@index');
    Route::post('coleta/{coleta_id}/product', 'ColetaProdutoController@store');
    Route::put('coleta/{coleta_id}/product/{item_id}', 'ColetaProdutoController@update');
    Route::delete('coleta/{coleta_id}/product/{item_id}', 'ColetaProdutoController@destroy');
    // Route::post('coleta/{coleta_id}/quantity', 'ColetaProdutoController@quantity');


    Route::get('produto/{id?}', 'ProdutoType@index');
    Route::post('produto', 'ProdutoType@store');
    Route::put('produto/{id}', 'ProdutoType@update');
    Route::delete('produto/{id}', 'ProdutoType@destroy');
    // Route::post('produto/{id}/quantity', 'ColetaProdutoController@quantity');
});
