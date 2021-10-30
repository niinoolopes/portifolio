<?php

namespace App\Http\Controllers;

class Controller_config extends Controller
{
    public function index()
    {
        $this->dados['pages'] = [
            (object) [
                'NOME' => 'Usuários',
                'DESCRICAO' => 'criação, edição e exclusão de usuários.',
                'LINK' => route('config.usuario'),
                'ICONE' => 'user-edit',
            ],
            (object) [
                'NOME' => 'Empresa',
                'DESCRICAO' => 'criação, edição e exclusão de Empresas.',
                'LINK' => route('config.empresa'),
                'ICONE' => 'building',
            ],
            (object) [
                'NOME' => 'Banco',
                'DESCRICAO' => 'criação, edição e exclusão de Bancos.',
                'LINK' => route('config.banco'),
                'ICONE' => 'university',
            ],
            (object) [
                'NOME' => 'Relatório',
                'DESCRICAO' => 'Relatório de pedidos',
                'LINK' => route('config.relatorio.pedido'),
                'ICONE' => 'file-alt',
            ],
            (object) [
                'NOME' => 'Formulários',
                'DESCRICAO' => 'Configurações de campos',
                'LINK' => route('config.form'),
                'ICONE' => 'clipboard-list',
            ],
            (object) [
                'NOME' => 'Pedido',
                'DESCRICAO' => 'Configurações de pedidos',
                'LINK' => route('config.motivoCancel'),
                'ICONE' => 'far fa-clipboard',
            ],
        ];

        $this->dados['titulo'] = 'Configurações';
        return view('pages.config', $this->dados);
    }
}
