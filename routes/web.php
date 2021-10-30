<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('usuario.lista');
});

Route::get('/usuario-lista',        'Usuario@lista')->name('usuario.lista');
Route::get('/usuario-add',          'Usuario@add')->name('usuario.add');
Route::get('/usuario-edit/{id?}',   'Usuario@edit')->name('usuario.edit');
Route::post('/usuario-store',       'Usuario@store')->name('usuario.store');
Route::post('/usuario-update/{id}', 'Usuario@update')->name('usuario.update');
Route::get('/usuario-delete/{id}',  'Usuario@delete')->name('usuario.delete');

Route::get('/analise', 'Analise@index')->name('analise');
Route::get('/analise/dados', 'Analise@dados')->name('analise.dados');