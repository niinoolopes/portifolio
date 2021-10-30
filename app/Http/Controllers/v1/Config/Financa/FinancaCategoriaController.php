<?php

namespace App\Http\Controllers\v1\Config\Financa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financa\Categoria\FinancaCategoriaRequestStore;
use App\Http\Requests\Financa\Categoria\FinancaCategoriaRequestUpdate;
use App\Http\Resources\Financa\Categoria\FinancaCategoriaCollection;
use App\Http\Resources\Financa\Categoria\FinancaCategoriaResource;
use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaCategoriaModel;
use App\Models\Financa\FinancaGrupoModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FinancaCategoriaController extends Controller
{
  public function index()
  {
    try {
      // options
      $per_page = key_exists('per_page', $_GET) ? $_GET['per_page'] : 15;

      // model
      $where['usua_id'] = Auth::user()->id;
      if (key_exists('fncg_enable', $_GET)) $where['fncg_enable'] = $_GET['fncg_enable'];
      if (key_exists('fncg_fechamento', $_GET)) $where['fncg_fechamento'] = $_GET['fncg_fechamento'];
      if (key_exists('fnct_id', $_GET)) $where['fnct_id'] = $_GET['fnct_id'];
      if (key_exists('fngp_id', $_GET)) $where['fngp_id'] = $_GET['fngp_id'];

      $model = FinancaCategoriaModel::with(['fngp', 'fnct'])
        ->where($where)
        ->whereHas('fnct', function ($query) {
          $where_fnct = [];
          $where_fnct['usua_id'] = Auth::user()->id;

          $query->where($where_fnct);
        })
        ->whereHas('fngp', function ($query) {
          $where_fngp = [];
          $where_fngp['usua_id'] = Auth::user()->id;

          if (key_exists('fntp_id', $_GET))
            $where_fngp['fntp_id'] = $_GET['fntp_id'];

          $query->where($where_fngp);
        });

      if ($model->count()) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaCategoriaCollection($model->paginate($per_page));
      } else {

        $sts = Response::HTTP_NO_CONTENT;
        $rtn = null;
      }
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function store(FinancaCategoriaRequestStore $request)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($request->fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $request->fnct_id) não existe!");

      // validate fngp_id
      $fngp_validate = FinancaGrupoModel::find($request->fngp_id);
      if (!$fngp_validate) throw new \Exception("Tipo (fngp_id: $request->fngp_id) não existe!");


      // model
      $model = new FinancaCategoriaModel();

      // array fields
      $fields = $request->only([
        'fncg_description', 'fncg_obs', 'fncg_enable', 'fncg_fechamento', 'fngp_id', 'fnct_id'
      ]);
      $fields['usua_id'] = Auth::user()->id;

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaCategoriaResource($model);
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function show($fncg_id)
  {
    try {
      // model
      $model = FinancaCategoriaModel::find($fncg_id);

      if ($model) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaCategoriaResource($model);
      } else {

        $sts = Response::HTTP_NO_CONTENT;
        $rtn = null;
      }
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function update(FinancaCategoriaRequestUpdate $request, $fncg_id)
  {
    try {
      // validate fncg_id
      $model = FinancaCategoriaModel::find($fncg_id);
      if (!$model) throw new \Exception("Categoria (fncg_id: $fncg_id) não existe!");

      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($request->fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $request->fnct_id) não existe!");

      // validate fngp_id
      $fngp_validate = FinancaGrupoModel::find($request->fngp_id);
      if (!$fngp_validate) throw new \Exception("Grupo (fngp_id: $request->fngp_id) não existe!");


      // array fields
      $fields = $request->only([
        'fncg_description', 'fncg_obs', 'fncg_enable', 'fncg_fechamento', 'fngp_id', 'fnct_id'
      ]);

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaCategoriaResource($model);
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  // public function destroy($id)
  // {
  // }
}
