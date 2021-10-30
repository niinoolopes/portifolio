<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario_tipo;
use App\Config;

class Controller_config_form extends Controller
{
    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');
        $this->dados['tab_form_cadastro'] = session()->get('tab_form_pedido') == null  ? true : session()->get('tab_usuario');
        $this->dados['tab_form_pedido'] = session()->get('tab_form_pedido');

        $Usuario_tipo = new Usuario_tipo;
        $this->dados['usuario_tipos_enable'] = $Usuario_tipo->getAllEnable();

        foreach (Config::all() as $value) {
            if ($value->DESCRICAO == 'FORM_CADASTRO')
                $this->dados['dados_FORM_CADASTRO'] = json_decode($value->JSON);
        }

        $this->dados['titulo'] = 'Config Empresa';
        return view('pages.config_form', $this->dados);
    }

    public function put(Request $request)
    {
        $TIPO_ID       = $request->post('TIPO_ID') == NULL ? [] : $request->post('TIPO_ID');
        $N_ATENDIMENTO = $request->post('N_ATENDIMENTO') == 'on' ? TRUE : false;
        $VALOR         = $request->post('VALOR') == 'on' ? TRUE : false;
        $DATA          = $request->post('DATA') == 'on' ? TRUE : false;
        $BANCO         = $request->post('BANCO') == 'on' ? TRUE : false;
        $COMPROVANTE   = $request->post('COMPROVANTE') == 'on' ? TRUE : false;

        $json = [
            "TIPO_ID" =>  $TIPO_ID,
            "N_ATENDIMENTO" =>  $N_ATENDIMENTO,
            "VALOR" =>  $VALOR,
            "DATA" =>  $DATA,
            "BANCO" =>  $BANCO,
            "COMPROVANTE" =>  $COMPROVANTE,
        ];

        $Config = new Config;

        if ($Config::where('DESCRICAO', '=', 'FORM_CADASTRO')->count()) {
            $res = $Config::where('DESCRICAO', '=', 'FORM_CADASTRO')->first();
            $res->JSON = json_encode($json);
            $res->save();
        } else {
            $Config->DESCRICAO = 'FORM_CADASTRO';
            $Config->JSON = json_encode($json);
            $Config->save();
        }

        $request->session()->flash('_msg', ['text' => 'Variáveis atualizadas!', 'tipo' => 'success']);
        $request->session()->flash('tab_form_cadastro', true);

        return redirect()->route('config.form');
    }
}
