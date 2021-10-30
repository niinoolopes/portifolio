<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banco;

class Controller_config_banco extends Controller
{
    private $exts = ['png', 'jpeg', 'jpg'];
    private $upload_path = '/images/bancos';
    private $file_name = 'LOGO-BANCO';

    private $dados = [];

    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['bancos'] = Banco::all();

        $this->dados['titulo'] = 'Config Banco';
        return view('pages.config_banco', $this->dados);
    }

    public function post(Request $request)
    {
        $nome = $request->post('NOME');
        /*
        if (Banco::where('NOME', '=', $request->post('NOME'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.banco');
        }
        */
        $BANCO_ID = Banco::insertGetId([
            "NOME"   => $request->post('NOME'),
            "CODIGO" => $request->post('CODIGO') == null ? '' : $request->post('CODIGO'),
            "SITE"   => $request->post('SITE') == null ? '' : $request->post('SITE'),
            "LOGO"   => $this->file_name,
            "STATUS" => 1,
        ]);

        if ($request->hasFile('LOGO') && $request->file('LOGO')->isValid()) {
            $LOGO     = $request->file('LOGO');
            $EXT      = strtolower($LOGO->extension());
            $LOGO_EXT = '-' . $BANCO_ID . '.' . $EXT;

            $this->file_name .= $LOGO_EXT;
            $this->file_name  = strtolower($this->file_name);

            // VALIDA EXTENSÃO ARQUIVO
            if (!in_array($EXT, $this->exts)) {
                $request->session()->flash('_msg', ['text' => "A imagem selecionada deve ter extenção png, jpg ou jpeg!", 'tipo' => 'danger']);
                return redirect()->route('config.banco');
            }

            // UPLOAD IMAGE
            $request->file('LOGO')->storeAs($this->upload_path, $this->file_name);

            // ATUALIZA CAMINHO DO LOGO
            $banco = Banco::find($BANCO_ID);
            $banco->LOGO = $this->file_name;
            $banco->save();
        }

        $request->session()->flash('_msg', ['text' => 'Banco cadastrado!', 'tipo' => 'success']);

        return redirect()->route('config.banco');
    }

    public function put(Request $request)
    {
        $nome = $request->post('NOME');
        /*
        if (Banco::where('NOME', '=', $request->post('NOME'))->where('BANCO_ID', '!=', $request->post('BANCO_ID'))->count()) {
            $request->session()->flash('_msg', ['text' => "O nome <strong>{$nome}</strong> informado já existe, não é permitido nomes iguais!", 'tipo' => 'danger']);
            return redirect()->route('config.banco');
        }
        */
        $banco = new Banco;

        $banco = $banco::where('BANCO_ID', '=', $request->post('BANCO_ID'))->first();

        if ($request->hasFile('LOGO') && $request->file('LOGO')->isValid()) {
            $LOGO     = $request->file('LOGO');
            $EXT      = strtolower($LOGO->extension());
            $LOGO_EXT = $banco->BANCO_ID . '.' . $EXT;

            $this->file_name .= $LOGO_EXT;
            $this->file_name  = strtolower($this->file_name);

            // VALIDA EXTENSÃO ARQUIVO
            if (!in_array($EXT, $this->exts)) {
                $request->session()->flash('_msg', ['text' => "A imagem selecionada deve ter extenção png, jpg ou jpeg!", 'tipo' => 'danger']);
                return redirect()->route('config.banco');
            }

            // UPLOAD IMAGE
            $request->file('LOGO')->storeAs($this->upload_path, $this->file_name);

            // ATUALIZA CAMINHO DO LOGO
            $banco = Banco::find($banco->BANCO_ID);
            $banco->LOGO = $this->file_name;
            $banco->save();
        }

        $banco->NOME    = $request->post('NOME');
        $banco->CODIGO  = $request->post('CODIGO') == null ? '' : $request->post('CODIGO');
        $banco->SITE    = $request->post('SITE') == null ? '' : $request->post('SITE');
        $banco->STATUS  = $request->post('STATUS') == 'on' ? 1 : 0;
        $banco->LOGO    = $this->file_name;
        $banco->save();

        $request->session()->flash('_msg', ['text' => 'Banco atualizado!', 'tipo' => 'success']);

        return redirect()->route('config.banco');
    }

    public function del(Request $request, $BANCO_ID)
    {
        $banco = new Banco;

        $banco = $banco::where('BANCO_ID', '=', $BANCO_ID)->first();

        $banco->delete();

        $request->session()->flash('_msg', ['text' => "Banco deletado!", 'tipo' => 'success']);

        return redirect()->route('config.banco');
    }
}
