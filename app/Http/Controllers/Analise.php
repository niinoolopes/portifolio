<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsuarioModel;
use Illuminate\Support\Facades\Route;

class Analise extends Controller
{
    private $data = [];
    
    function __construct()
    {
        $this->data['sidebar'] = 'analise_sidebar';
        $this->data['sidebar_text'] = 'Análise';
        $this->data['routeName'] = Route::currentRouteName();
    }

    public function index() {
        $this->data['main'] = 'analise_lista';

        return view('layout.default', $this->data);
    }

    public function dados() {

        $this->usuarioModel = new UsuarioModel;
        $usuarios = $this->usuarioModel->orderBy('USUARIO_DATA_NASCIMENTO')->get()->toArray();

        foreach($usuarios as $key => $usuario){
            $dataHoje    = date('Y-m-d');
            $dateUsuario = $usuario['USUARIO_DATA_NASCIMENTO'];

            $date_diff = date_diff(
                date_create($dataHoje),
                date_create($dateUsuario)
            );

            // IDENTIFICA IDADE ATUAL POR USUARIO
            $usuario['IDADE'] = $date_diff->y;
            $usuarios[$key] = $usuario;
        }


        // APURA IDADE MENOR/MAIOR
        $this->dados['idade_Menor'] = reset($usuarios)['IDADE'];
        $this->dados['idade_Maior'] = end($usuarios)['IDADE'];

        // APURA MÉDIA DE IDADE
        $columns = array_column($usuarios, 'IDADE');
        $mediaIdade = array_sum($columns) / count($usuarios);
        $this->dados['media_de_idade'] = number_format($mediaIdade, 1, ',', '');

        // APURA QUANDIDADE MASCULINO/FEMININO
        $this->dados['total_Masculino'] = count( array_filter($usuarios, function($usuario){
            return $usuario['USUARIO_SEXO'] == 'M';
        }));
        $this->dados['total_Femenino'] = count( array_filter($usuarios, function($usuario){
            return $usuario['USUARIO_SEXO'] == 'F';
        }));

        return response()->json($this->dados);
    }
}
