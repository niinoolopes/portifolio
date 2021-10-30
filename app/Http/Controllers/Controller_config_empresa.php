<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;

class Controller_config_empresa extends Controller
{
    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['empresas'] = Empresa::all();

        $this->dados['titulo'] = 'Config Empresa';

        return view('pages.config_empresa', $this->dados);
    }

    public function post(Request $request)
    {
        $empresa = new Empresa;
        $nome = $request->post('CARGO_NOME');
        /*
        if ($empresa::where('NOME', '=', $request->post('NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.empresa');
        }
        */
        $empresa->NOME   = $request->post('NOME');
        $empresa->COR    = $request->post('COR');
        $empresa->STATUS = 1;

        $empresa->save();

        $request->session()->flash('_msg', ['text' => 'Empresa cadastrada!', 'tipo' => 'success']);

        return redirect()->route('config.empresa');
    }

    public function put(Request $request)
    {
        $empresa = new Empresa;
        $nome = $request->post('CARGO_NOME');
        /*
        if ($empresa::where('NOME', '=', $request->post('NOME'))->where('EMPRESA_ID', '!=', $request->post('EMPRESA_ID'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.empresa');
        }
        */
        $empresa = $empresa::where('EMPRESA_ID', '=', $request->post('EMPRESA_ID'))->first();

        $empresa->NOME   = $request->post('NOME');
        $empresa->COR    = $request->post('COR');
        $empresa->STATUS = $request->post('STATUS') == 'on' ? 1 : 0;

        $empresa->save();

        $request->session()->flash('_msg', ['text' => 'Empresa atualizada!', 'tipo' => 'success']);

        return redirect()->route('config.empresa');
    }

    public function del(Request $request, $EMPRESA_ID)
    {
        $empresa = new Empresa;

        $empresa = $empresa::where('EMPRESA_ID', '=', $EMPRESA_ID)->first();

        $empresa->delete();

        $request->session()->flash('_msg', ['text' => "Empresa deletada!", 'tipo' => 'success']);

        return redirect()->route('config.empresa');
    }
}
