<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Route;

class Check_route
{
    public function handle($request, Closure $next)
    {
        $affter = url()->current();

        $rotaAtual = Route::currentRouteName();

        $rotas = [
            'config',
            'config.usuario',
            'config.usuario.post',
            'config.usuario.put',
            'config.usuario.tipo.post',
            'config.usuario.tipo.put',
            'config.usuario.cargo.post',
            'config.usuario.cargo.put',
            'config.vendedor',
            'config.vendedor.post',
            'config.vendedor.put',
            'config.empresa',
            'config.empresa.post',
            'config.empresa.put',
            'config.banco',
            'config.vendedor.post',
            'config.vendedor.put',
        ];
        if (in_array($rotaAtual, $rotas)) {
            if (session()->get('USUARIO.PERMISSAO_CONFIG') != 'S') {
                // if (session()->get('USUARIO.USUARIO_ID') != 1) {
                session()->flash('_msg', ['text' => "Seu usuário não tem acesso para '{$affter}'!", 'tipo' => 'danger']);
                return redirect()->route('pedido.painel');
            }
        }
        return $next($request);
    }
}
