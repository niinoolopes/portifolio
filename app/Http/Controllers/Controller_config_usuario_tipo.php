<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario_tipo;

class Controller_config_usuario_tipo extends Controller
{

    public function post(Request $request)
    {
        $request->session()->flash('tab_tipo', true);

        $tipo = new Usuario_tipo;
        $nome = $request->post('TIPO_NOME');

        if ($tipo::where('TIPO_NOME', '=', $request->post('TIPO_NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.usuario');
        }

        $tipo->TIPO_NOME = $nome;
        $tipo->TIPO_STATUS = $request->post('TIPO_STATUS') == 'on' ? 1 : 0;

        $tipo->save();

        $request->session()->flash('_msg', ['text' => 'Tipo usuário criado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }

    public function put(Request $request)
    {
        $request->session()->flash('tab_tipo', true);

        $tipo = new Usuario_tipo;
        $nome = $request->post('TIPO_NOME');

        if ($tipo::where('TIPO_NOME', '=', $request->post('TIPO_NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.usuario');
        }

        $tipo = $tipo::where('TIPO_ID', '=', $request->post('TIPO_ID'))->first();

        $tipo->TIPO_NOME = $request->post('TIPO_NOME');
        $tipo->TIPO_STATUS = $request->post('TIPO_STATUS') == 'on' ? 1 : 0;

        $tipo->save();

        $request->session()->flash('_msg', ['text' => 'Tipo usuário atualizado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }

    public function del(Request $request, $TIPO_ID)
    {
        $request->session()->flash('tab_tipo', true);

        $Usuario_tipo = new Usuario_tipo;

        $tipo = $Usuario_tipo::where('TIPO_ID', '=', $TIPO_ID)->first();

        $tipo->delete();

        $request->session()->flash('_msg', ['text' => 'Tipo usuário deletado!', 'tipo' => 'success']);

        return redirect()->route('config.usuario');
    }
}
