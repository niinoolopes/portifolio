<?php

namespace App\Http\Controllers;

use App\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Motorista $motorista, $MOT_ID = false)
    {
        try {
            if ($MOT_ID) {
                $data = $motorista::find($MOT_ID);
                if (!$data) return response()->json(['message' => "ID $MOT_ID não encontrado!"], 400);
            } else {
                $data = $motorista::all();
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
    public function store(Request $request, Motorista $motorista)
    {
        $validateFields = $this->validateFields(
            $request,
            $motorista,
            'MOT',
            ['MOT_LOGIN', 'MOT_PASSWORD', 'MOT_NOME', 'MOT_EMAIL', 'MOT_PIX', 'MOT_WHATSAPP'],
            ''
        );
        if ($validateFields !== false) return response()->json($validateFields, 400);

        $MOT = $motorista;
        $MOT->MOT_ID       = $request->get('MOT_ID');
        $MOT->MOT_LOGIN    = $request->get('MOT_LOGIN');
        $MOT->MOT_PASSWORD = $request->get('MOT_PASSWORD');
        $MOT->MOT_NOME     = $request->get('MOT_NOME');
        $MOT->MOT_EMAIL    = $request->get('MOT_EMAIL');
        $MOT->MOT_PIX      = $request->get('MOT_PIX');
        $MOT->MOT_WHATSAPP = $request->get('MOT_WHATSAPP');
        $MOT->save();

        return response()->json(['message' => 'Motorista cadastrado!', 'data' => $MOT]);
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Motorista $motorista
     * @return \Illuminate\Http\Response
     */
    public function show(Motorista $motorista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Motorista $motorista
     * @return \Illuminate\Http\Response
     */
    public function edit(Motorista $motorista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Motorista $motorista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motorista $motorista, $MOT_ID)
    {
        try {
            $validateFields = $this->validateFields(
                $request,
                $motorista,
                'MOT',
                ['MOT_LOGIN', 'MOT_PASSWORD', 'MOT_NOME', 'MOT_EMAIL', 'MOT_PIX', 'MOT_WHATSAPP'],
                $MOT_ID
            );
            if ($validateFields !== false) return response()->json($validateFields, 400);

            $MOT = $motorista::find($MOT_ID);

            if ($MOT) {
                $MOT->MOT_LOGIN    = $request->get('MOT_LOGIN');
                $MOT->MOT_PASSWORD = $request->get('MOT_PASSWORD');
                $MOT->MOT_NOME     = $request->get('MOT_NOME');
                $MOT->MOT_EMAIL    = $request->get('MOT_EMAIL');
                $MOT->MOT_PIX      = $request->get('MOT_PIX');
                $MOT->MOT_WHATSAPP = $request->get('MOT_WHATSAPP');
                $MOT->save();

                return response()->json(['message' => 'Motorista atualizado!', 'data' => $MOT]);
            } else {
                return response()->json(['message' => "ID $MOT_ID não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Motorista $motorista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motorista $motorista, $MOT_ID)
    {
        try {
            $MOT = $motorista::find($MOT_ID);

            if ($MOT) {
                $MOT->delete();
                return response()->json(['message' => 'Motorista deletado!']);
            } else {
                return response()->json(['message' => "ID $MOT_ID não encontrado!"], 400);
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
        
        return false;
    }
}
