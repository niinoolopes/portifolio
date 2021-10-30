<?php

use Illuminate\Support\Facades\Route;

$painel    = Route::currentRouteName() == 'painel'          ? 'active' : '';
$cadastrar = Route::currentRouteName() == 'pedido.cadastrar'? 'active' : '';
$consultar = Route::currentRouteName() == 'consultar'       ? 'active' : '';
$login     = Route::currentRouteName() == 'login'           ? 'active' : '';
echo $pedido    = Route::currentRouteName() == 'pedido'          ? 'active' : '';

$config = [];
$config[]  = Route::currentRouteName() == 'config'          ? 'active' : '';
// $config[]  = Route::currentRouteName() == 'config.usuario'  ? 'active' : '';
// $config[]  = Route::currentRouteName() == 'config.vendedor' ? 'active' : '';
// $config[]  = Route::currentRouteName() == 'config.empresa'  ? 'active' : '';
// $config[]  = Route::currentRouteName() == 'config.banco'    ? 'active' : '';
$config = array_filter($config, function ($val) {
    return $val;
});
$config = reset($config);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('public') }}/css/app.css?v='{{ date('Y-m-d-i-s') }}'">
    <link rel="stylesheet" href="{{ url('public') }}/css/geral.css?v='{{ date('Y-m-d-i-s') }}'">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script>
        const PATH = '<?= url('/') ?>';
        const pedido_logo_default = 'https://via.placeholder.com/120x60';
    </script>
    <title>{{$titulo}}</title>
</head>

<body>

    <header class="mb-3 bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="d-flex">
                    <a class="navbar-brand" href="{{ route('home') }}">Sad</a>
                    <div class="d-flex flex-row align-items-center">
                        <a class="btn btn-teal btn-sm mr-2 {{$cadastrar}}" href="{{ route('pedido.cadastrar') }}">Cadastrar</a>
                        @if( !session()->get('LOGIN') )
                        <a class="btn btn-teal btn-sm mr-2 {{$consultar}}" href="{{ route('pedido.consultar') }}">Consultar</a>
                        @endif
                        @if( session()->get('LOGIN') )
                        <a class="btn btn-teal btn-sm mr-2 {{$painel}}" href="{{ route('pedido.painel') }}">Painel</a>
                        @endif
                        <a class="btn btn-teal btn-sm {{$pedido}}" href="{{ route('pedido.consultarPedido') }}">Pedido</a>
                    </div>
                </div>
                <div>
                    @if( session()->get('LOGIN') )
                    @if( session()->get('USUARIO.USUARIO_ID') == 1 || session()->get('USUARIO.PERMISSAO_CONFIG') === 'S')
                    <a class="icon d-inline-block rounded {{$config}}" href="{{ route('config') }}">
                        <div class="d-flex justify-content-center align-items-center p-2">
                            <i class="far fa-lg fa-cog text-dark"></i>
                        </div>
                    </a>
                    @endif
                    <a class="icon d-inline-block rounded" href="{{ route('login.logout') }}">
                        <div class="d-flex justify-content-center align-items-center p-2">
                            <i class="far fa-lg fa-sign-in-alt text-dark"></i>
                        </div>
                    </a>
                    @else
                    <a class="icon d-inline-block rounded" href="{{ route('login') }}">
                        <div class="d-flex justify-content-center align-items-center p-2">
                            <i class="far fa-lg fa-user text-dark"></i>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </nav>
    </header>