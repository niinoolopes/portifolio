<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Usuario_tipo;
use App\Usuario_cargo;

class Controller_home extends Controller
{
    private $dados = [];

    public function home()
    {
        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['titulo'] = 'HOME';

        return view('pages.home', $this->dados);
    }
}
