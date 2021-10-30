<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use App\Usuario;
use App\Vendedor;

class Check_login
{
    public function handle($request, Closure $next)
    {
        
        if (!session()->get('LOGIN')) {
            $request->session()->flash('_msg', ['text' => "Faça login para ter acesso!", 'tipo' => 'danger']);
            return redirect('/login');
        }

        return $next($request);
    }
}
