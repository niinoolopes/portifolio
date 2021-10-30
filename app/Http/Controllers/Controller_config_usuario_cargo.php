<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario_cargo;

class Controller_config_usuario_cargo extends Controller
{

    public function post(Request $request)
    {
        $request->session()->flash('tab_cargo', true);

        $cargo = new Usuario_cargo;
        $nome = $request->post('CARGO_NOME');

        if ($cargo::where('CARGO_NOME', '=', $request->post('CARGO_NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.usuario');
        }

        $cargo->CARGO_NOME = $request->post('CARGO_NOME');
        $cargo->CARGO_STATUS = $request->post('CARGO_STATUS') == 'on' ? 1 : 0;

        $cargo->save();

        $request->session()->flash('_msg', ['text' => 'Cargo de usuário criado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }

    public function put(Request $request)
    {
        $request->session()->flash('tab_cargo', true);

        $Usuario_cargo = new Usuario_cargo;
        $nome = $request->post('CARGO_NOME');

        if ($Usuario_cargo::where('CARGO_NOME', '=', $request->post('CARGO_NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.usuario');
        }

        $cargo = $Usuario_cargo::where('CARGO_ID', '=', $request->post('CARGO_ID'))->first();

        $cargo->CARGO_NOME = $request->post('CARGO_NOME');
        $cargo->CARGO_STATUS = $request->post('CARGO_STATUS') == 'on' ? 1 : 0;

        $cargo->save();

        $request->session()->flash('_msg', ['text' => 'Cargo de usuário atualizado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }

    public function del(Request $request, $CARGO_ID)
    {
        $request->session()->flash('tab_cargo', true);

        $Usuario_cargo = new Usuario_cargo;
        $nome = $request->post('CARGO_NOME');

        $cargo = $Usuario_cargo::where('CARGO_ID', '=', $CARGO_ID)->first();

        $cargo->delete();

        $request->session()->flash('_msg', ['text' => 'Cargo de usuário deletado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }
}
