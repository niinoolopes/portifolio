<?php

namespace App\Http\Controllers;

use App\ColetaProduto;
use App\Http\Resources\Coleta\ColetaProdutoResource;
use Illuminate\Http\Request;


class ColetaProdutoController extends Controller
{
    public function index($cole_id = false, $colp_id = false)
    {
        $data = ($colp_id)
            ? ColetaProduto::where(['cole_id' => $cole_id, 'colp_id' => $colp_id])->get()
            : ColetaProduto::where('cole_id', $cole_id)->get();
        // dd($where);

        foreach ($data as $key => $value) {
            $value->copt = $value->copt();
            $data[$key] = new ColetaProdutoResource($value);
        }

        return response()->json([
            'data' => ($colp_id) ? $data[0] : $data
        ]);
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function store(Request $request, $cole_id)
    {
        try {
            $coletaProdutoModel = new ColetaProduto;

            $coletaProdutoModel->colp_description = $request['colp_description'];
            $coletaProdutoModel->colp_quantity    = 0;
            $coletaProdutoModel->colp_price_unit  = 0;
            $coletaProdutoModel->colp_price       = 0;
            $coletaProdutoModel->colp_status      = 1;
            $coletaProdutoModel->cole_id          = $cole_id;
            $coletaProdutoModel->copt_id          = $request['copt_id'];
            $coletaProdutoModel->save();

            $coletaProdutoModel->copt = $coletaProdutoModel->copt();

            return response()->json([
                'message' => 'Produto cadastrado!',
                'data' => new ColetaProdutoResource($coletaProdutoModel)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function update(Request $request, $cole_id, $colp_id)
    {
        $coletaProdutoModel = ColetaProduto::where(['cole_id' => $cole_id, 'colp_id' => $colp_id])->first();

        if ($coletaProdutoModel) {
            if (isset($request['colp_description'])) $coletaProdutoModel->colp_description = $request['colp_description'];
            if (isset($request['colp_quantity']))    $coletaProdutoModel->colp_quantity    = $request['colp_quantity'];
            if (isset($request['colp_price_unit']))  $coletaProdutoModel->colp_price_unit  = $request['colp_price_unit'];
            if (isset($request['colp_price']))       $coletaProdutoModel->colp_price       = $request['colp_price'];
            if (isset($request['colp_status']))      $coletaProdutoModel->colp_status      = $request['colp_status'];
            $coletaProdutoModel->save();

            $coletaProdutoModel->copt = $coletaProdutoModel->copt();

            return response()->json([
                'message' => 'Produto atualizado!',
                'data' => new ColetaProdutoResource($coletaProdutoModel)
            ]);
        } else {
            return response()->json(['message' => "ID $colp_id não encontrado!"], 400);
        }

        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function quantity(Request $request,  $colp_id)
    {
        try {
            $coletaProdutoModel = ColetaProduto::where(['colp_id' => $colp_id])->first();

            if ($coletaProdutoModel) {
                if (isset($request['colp_quantity']))    $coletaProdutoModel->colp_quantity    = $request['colp_quantity'];
                $coletaProdutoModel->save();

                return response()->json([
                    'message' => 'Quantidade atualizada!',
                    'data' => new ColetaProdutoResource($coletaProdutoModel)
                ]);
            } else {
                return response()->json(['message' => "ID $colp_id não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }
    public function destroy($cole_id, $colp_id)
    {
        $coleta = ColetaProduto::where(['cole_id' => $cole_id, 'colp_id' => $colp_id])->first();

        if ($coleta) {
            $coleta->delete();

            return response()->json(['message' => 'Produto deletado da coleta!']);
        } else {
            return response()->json(['message' => "ID $colp_id não encontrado!"], 400);
        }
        try {
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }
}
