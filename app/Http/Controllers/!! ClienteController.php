<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cliente $cliente, $CLI_ID = false)
    {
        try {
            if ($CLI_ID) {
                $data = $cliente::find($CLI_ID);
                if (!$data) return response()->json(['message' => "ID $CLI_ID não encontrado!"], 400);
            } else {
                $data = $cliente::all();
            }

            return response()->json(['data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Cliente $cliente)
    {
        try {
            $validateFields = $this->validateFields(
                $request,
                $cliente,
                'CLI',
                ['CLI_LOGIN', 'CLI_PASSWORD', 'CLI_NOME', 'CLI_EMAIL', 'CLI_CNPJ', 'CLI_PIX', 'CLI_WHATSAPP', 'CLI_RUA', 'CLI_ENDERECO', 'CLI_NUM', 'CLI_BAIRRO', 'CLI_CIDADE', 'CLI_BANCO', 'CLI_AGENCIA', 'CLI_CONTA'],
                ''
            );
            if ($validateFields !== true) return response()->json($validateFields, 400);


            $CLI = $cliente;
            $CLI->CLI_LOGIN    = $request->get('CLI_LOGIN');
            $CLI->CLI_PASSWORD = $request->get('CLI_PASSWORD');
            $CLI->CLI_NOME     = $request->get('CLI_NOME');
            $CLI->CLI_EMAIL    = $request->get('CLI_EMAIL');
            $CLI->CLI_CNPJ     = $request->get('CLI_CNPJ');
            $CLI->CLI_PIX      = $request->get('CLI_PIX');
            $CLI->CLI_WHATSAPP = $request->get('CLI_WHATSAPP');
            $CLI->CLI_RUA      = $request->get('CLI_RUA');
            $CLI->CLI_ENDERECO = $request->get('CLI_ENDERECO');
            $CLI->CLI_NUM      = $request->get('CLI_NUM');
            $CLI->CLI_BAIRRO   = $request->get('CLI_BAIRRO');
            $CLI->CLI_CIDADE   = $request->get('CLI_CIDADE');
            $CLI->CLI_BANCO    = $request->get('CLI_BANCO');
            $CLI->CLI_AGENCIA  = $request->get('CLI_AGENCIA');
            $CLI->CLI_CONTA    = $request->get('CLI_CONTA');
            $CLI->save();

            return response()->json(['message' => 'Cliente cadastrado!', 'data' => $CLI]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente, $CLI_ID)
    {
        try {
            $validateFields = $this->validateFields(
                $request,
                $cliente,
                'CLI',
                ['CLI_LOGIN', 'CLI_PASSWORD', 'CLI_NOME', 'CLI_EMAIL', 'CLI_CNPJ', 'CLI_PIX', 'CLI_WHATSAPP', 'CLI_RUA', 'CLI_ENDERECO', 'CLI_NUM', 'CLI_BAIRRO', 'CLI_CIDADE', 'CLI_BANCO', 'CLI_AGENCIA', 'CLI_CONTA'],
                $CLI_ID
            );
            if ($validateFields !== true) return response()->json($validateFields, 400);

            $CLI = $cliente::find($CLI_ID);

            if ($CLI) {
                $CLI->CLI_LOGIN    = $request->get('CLI_LOGIN');
                $CLI->CLI_PASSWORD = $request->get('CLI_PASSWORD');
                $CLI->CLI_NOME     = $request->get('CLI_NOME');
                $CLI->CLI_EMAIL    = $request->get('CLI_EMAIL');
                $CLI->CLI_CNPJ     = $request->get('CLI_CNPJ');
                $CLI->CLI_PIX      = $request->get('CLI_PIX');
                $CLI->CLI_WHATSAPP = $request->get('CLI_WHATSAPP');
                $CLI->CLI_RUA      = $request->get('CLI_RUA');
                $CLI->CLI_ENDERECO = $request->get('CLI_ENDERECO');
                $CLI->CLI_NUM      = $request->get('CLI_NUM');
                $CLI->CLI_BAIRRO   = $request->get('CLI_BAIRRO');
                $CLI->CLI_CIDADE   = $request->get('CLI_CIDADE');
                $CLI->CLI_BANCO    = $request->get('CLI_BANCO');
                $CLI->CLI_AGENCIA  = $request->get('CLI_AGENCIA');
                $CLI->CLI_CONTA    = $request->get('CLI_CONTA');
                $CLI->save();

                return response()->json(['message' => 'Cliente atualizado!', 'data' => $CLI]);
            } else {
                return response()->json(['message' => "ID $CLI_ID não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, $CLI_ID)
    {
        try {
            $CLI = $cliente::find($CLI_ID);

            if ($CLI) {
                $CLI->delete();
                return response()->json(['message' => 'Cliente deletado!']);
            } else {
                return response()->json(['message' => "ID $CLI_ID não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    private function validateFields($request, $model, $alias, $fields, $ID)
    {
        $fieldsEmpty = [];

        foreach ($fields as $field) {
            if (!isset($request[$field])) {
                $fieldsEmpty[] = "$field é obrigatório!";
            }
        }

        if (count($fieldsEmpty) > 0) return ['message' => $fieldsEmpty];


        $exist = $model::where("{$alias}_LOGIN", $request["{$alias}_LOGIN"])
            ->where("{$alias}_ID", '!=', $ID)
            ->count();

        if ($exist) {
            return ['message' => "Login '{$request["{$alias}_LOGIN"]}' já existente!"];
        }

        $exist = $model::where("{$alias}_EMAIL", $request["{$alias}_EMAIL"])
            ->where("{$alias}_ID", '!=', $ID)
            ->count();

        if ($exist) {
            return ['message' => "Email '{$request["{$alias}_EMAIL"]}' já existente!"];
        }

        return true;
    }
}
