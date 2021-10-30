<?php

namespace App\Http\Controllers;

use App\Http\Resources\Produto\ProdutoResource;
use App\ProdutoType as ProdutoTypeModel;
use Illuminate\Http\Request;

class ProdutoType extends Controller
{
    public function index($id = false)
    {
        try {
            if ($id) {
                $data = ProdutoTypeModel::where(['copt_id' => $id])->get();
                if (!$data) return response()->json(['message' => "ID $id não encontrado!"], 400);
            } else {
                $data = ProdutoTypeModel::all();
            }

            foreach ($data as $key => $value) {
                $data[$key] = new ProdutoResource($value);
            }

            return response()->json([
                'data' => ($id) ? $data[0] : $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $produtoTypeModel = new ProdutoTypeModel;
            $produtoTypeModel->copt_type   = $request['copt_type'];
            $produtoTypeModel->copt_price  = $request['copt_price'];
            $produtoTypeModel->copt_status = 1;
            $produtoTypeModel->save();

            $data = $produtoTypeModel;

            return response()->json([
                'message' => 'Tipo de produto cadastrado!',
                'data' => new ProdutoResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produtoTypeModel = ProdutoTypeModel::find($id);

            if ($produtoTypeModel) {

                $produtoTypeModel->copt_type   = $request['copt_type'];
                $produtoTypeModel->copt_price  = $request['copt_price'];
                $produtoTypeModel->copt_status = $request['copt_status'];
                $produtoTypeModel->save();

                $data = $produtoTypeModel;

                return response()->json([
                    'message' => 'Tipo de produto atualizado!',
                    'data' => new ProdutoResource($data)
                ]);
            } else {
                return response()->json(['message' => "ID $id não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = ProdutoTypeModel::find($id);

            if ($result->count()) {
                $result->delete();
                return response()->json(['message' => 'Tipo de produto deletado!']);
            } else {
                return response()->json(['message' => "ID $id não encontrado!"], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ocorreu um erro inesperado. contate o administrador do sistema!'], 500);
        }
    }
}
