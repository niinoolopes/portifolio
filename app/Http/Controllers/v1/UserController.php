<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaCategoriaModel;
use App\Models\Financa\FinancaGrupoModel;
use App\Models\Financa\FinancaSituacaoModel;
use App\Models\Financa\FinancaTipoModel;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
  public function update(Request $request)
  {
    try {
      // validate fields
      $request->validate([
        'name' => 'required',
        'email' => 'required|email',
      ]);

      if (key_exists('password', $request->all())) {
        $request['password'] = Hash::make($request['password']);
      }

      $id = $request->user()->id;
      $fields = $request->only('name', 'email', 'password');

      // update
      User::where('id', $id)->update($fields);

      $sts = Response::HTTP_CREATED;
      $rtn = [
        'message' => "Perfil atualizado",
        'data' => new UserResource(User::find($id))
      ];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function fullData()
  {
    try {
      // dados do usuario
      $user = Auth::user();
      $usua_id = $user->id;

      $sts = Response::HTTP_OK;
      $rtn = [
        'PERIODO' => date('Y-m'),
        'USUARIO' => new UserResource($user),
        'FINANCA' => [
          'carteira' => FinancaCarteiraModel::where(['usua_id' => $usua_id])->get(),
          'grupo' => FinancaGrupoModel::where(['usua_id' => $usua_id])->get(),
          'categoria' => FinancaCategoriaModel::where(['usua_id' => $usua_id])->get(),
          'tipo' => FinancaTipoModel::all(),
          'situacao' => FinancaSituacaoModel::all(),
        ]
      ];
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }
}
