<?php

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

Route::get('/', 'Controller_home@home')->name('home');


Route::get('/login',        'Controller_login@index')->name('login');
Route::post('/login-do',    'Controller_login@do')->name('login.do');
Route::get('/login-logout', 'Controller_login@logout')->name('login.logout');
Route::get('/login-token',  'Controller_login@updateToken')->name('login.token');

Route::get('/reset-banco',  'Controller_login@initBanco')->name('reset.banco');
Route::get('/job/{id}',     'Controller_login@job');
Route::get('/teste',     'Controller_login@teste');

Route::post('/consultar-pedido',    'Controller_pedido@consultarPedido')->name('pedido.consultarPedido.busca');
Route::get('/consultar-pedido',     'Controller_pedido@consultarPedido')->name('pedido.consultarPedido');

Route::middleware(['Check_login', 'Check_route'])->group(function () {

    Route::get('/pedido',       'Controller_pedido@cadastrar')->name('pedido.cadastrar');
    Route::post('/pedido/post', 'Controller_pedido@post')->name('pedido.post');
    Route::post('/pedido/put/{id}', 'Controller_pedido@put')->name('pedido.put');

    Route::post('/consultar',   'Controller_pedido@consultar')->name('pedido.consultar.busca');
    Route::get('/consultar',    'Controller_pedido@consultar')->name('pedido.consultar');

    // page painel
    // Route::post('/painel', function () { die('oi'); })->name('pedido.painel.busca');
    Route::post('/painel',            'Controller_pedido@painel')->name('pedido.painel.busca');
    Route::get('/painel',             'Controller_pedido@painel')->name('pedido.painel');
    Route::get('/pedido/{acao}/{id}/{motivo?}', 'Controller_pedido@statusPedido')->name('pedido.acao');

    // page config
    Route::get('/configuracao', 'Controller_config@index')->name('config');

    // page config/sistem
    Route::get('/configuracao/form', 'Controller_config_form@index')->name('config.form');
    Route::post('/configuracao/form/put', 'Controller_config_form@put')->name('config.form.put');

    // page config/usuario
    Route::get('/configuracao/usuario',             'Controller_config_usuario@index')->name('config.usuario');

    Route::post('/configuracao/usuario/post',          'Controller_config_usuario@post')->name('config.usuario.post');
    Route::post('/configuracao/usuario/put',           'Controller_config_usuario@put')->name('config.usuario.put');
    Route::post('/configuracao/usuario-tipo/post',     'Controller_config_usuario_tipo@post')->name('config.usuario.tipo.post');
    Route::post('/configuracao/usuario-tipo/put',      'Controller_config_usuario_tipo@put')->name('config.usuario.tipo.put');
    Route::get('/configuracao/usuario-tipo/del/{id}',  'Controller_config_usuario_tipo@del')->name('config.usuario.tipo.del');
    Route::post('/configuracao/usuario-cargo/post',    'Controller_config_usuario_cargo@post')->name('config.usuario.cargo.post');
    Route::post('/configuracao/usuario-cargo/put',     'Controller_config_usuario_cargo@put')->name('config.usuario.cargo.put');
    Route::get('/configuracao/usuario-cargo/del/{id}', 'Controller_config_usuario_cargo@del')->name('config.usuario.cargo.del');

    // page config/empresa
    Route::get('/configuracao/empresa',          'Controller_config_empresa@index')->name('config.empresa');
    Route::post('/configuracao/empresa/post',    'Controller_config_empresa@post')->name('config.empresa.post');
    Route::post('/configuracao/empresa/put',     'Controller_config_empresa@put')->name('config.empresa.put');
    Route::get('/configuracao/empresa/del/{id}', 'Controller_config_empresa@del')->name('config.empresa.del');

    // page config/banco
    Route::get('/configuracao/banco',          'Controller_config_banco@index')->name('config.banco');
    Route::post('/configuracao/banco/post',    'Controller_config_banco@post')->name('config.banco.post');
    Route::post('/configuracao/banco/put',     'Controller_config_banco@put')->name('config.banco.put');
    Route::get('/configuracao/banco/del/{id}', 'Controller_config_banco@del')->name('config.banco.del');

    // page config/motivoCancelamento
    Route::get('/configuracao/motivo-cencelamento',          'Controller_config_motivoCencelamento@index')->name('config.motivoCancel');
    Route::post('/configuracao/motivo-cencelamento/post',    'Controller_config_motivoCencelamento@post')->name('config.motivoCancel.post');
    Route::post('/configuracao/motivo-cencelamento/put',     'Controller_config_motivoCencelamento@put')->name('config.motivoCancel.put');
    Route::get('/configuracao/motivo-cencelamento/del/{id}', 'Controller_config_motivoCencelamento@del')->name('config.motivoCancel.del');

    // page config/relatorio
    Route::post('/configuracao/relatorio', 'Controller_config_relatorio@pedido')->name('config.relatorio.pedido.post');
    Route::get('/configuracao/relatorio',  'Controller_config_relatorio@pedido')->name('config.relatorio.pedido');
});
