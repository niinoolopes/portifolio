<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Banco;
use App\Empresa;
use App\Pedido;
use App\Config;

class Controller_config_relatorio extends Controller
{

    private $dados = [];

    public function pedido(Request $request)
    {
        die('aa');
        $this->dados_config();

        $Usuario = new Usuario;
        $this->dados['vendedores']  = $Usuario->getAllVendedores($this->dados['config']->TIPO_ID);

        $this->dados['bancos'] = Banco::all();

        $this->dados['empresas'] = Empresa::all();

        if ($request->has('GERAR')) {
            $this->dados['campo'] = $request->input();

            $pedidos = new Pedido;
            $pedidos = $pedidos->relatorio($request->input());
            $name_file = 'relatorio_pedido_' . date('d-m-Y-H-i-s');

            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename={$name_file}.csv");
            header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');

            $output = fopen('php://output', 'w');

            $coll = array(
                utf8_decode('N ATENDIMENTO'),
                utf8_decode('BANCO'),
                utf8_decode('VALOR'),
                utf8_decode('DATA TRANSFERENCIA'),
                utf8_decode('VENDEDOR'),
                utf8_decode('EMPRESA'),
                utf8_decode('DATA PEDIDO'),
                utf8_decode('STATUS PEDIDO'),
            );

            fputcsv($output, $coll, ";");

            foreach ($pedidos as $dados) {

                $str = array(
                    utf8_decode($dados->N_ATENDIMENTO),
                    utf8_decode($dados->B_NOME),
                    utf8_decode($dados->VALOR),
                    utf8_decode($dados->DATA_TRANSFERENCIA),
                    utf8_decode($dados->U_NOME),
                    utf8_decode($dados->E_NOME),
                    utf8_decode($dados->created_at),
                    utf8_decode($dados->S_DESCRICAO),
                );

                fputcsv($output, $str, ";");
            }
            fclose($output);
            die;
        } else {
            $this->dados['campo'] = (object) [
                'DATA_DE'   => date('Y-m-d'),
                'DATA_ATE'  => date('Y-m-d'),
                'BANCO'     => [],
                'VENDEDOR'  => [],
                'EMPRESA'   => [],
            ];
        }

        $this->dados['titulo'] = 'Relatório Pedido';
        return view('pages.relatorio_pedido', $this->dados);
    }

    private function dados_config()
    {
        $config = Config::where('DESCRICAO', 'FORM_CADASTRO')->first();
        if (is_object($config) || is_array($config)) {
            $this->dados['config'] = json_decode($config->JSON);
            $this->dados['aviso'] = false;
        } else {
            $this->dados['config'] = [
                "TIPO_ID"       =>  [],
                "N_ATENDIMENTO" =>  false,
                "VALOR"         =>  false,
                "DATA"          =>  false,
                "BANCO"         =>  false,
                "COMPROVANTE"   =>  false,
            ];
            $this->dados['aviso'] = true;
        }
    }
}
