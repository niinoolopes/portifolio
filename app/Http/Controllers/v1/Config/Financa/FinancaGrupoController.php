<?php

namespace App\Http\Controllers\v1\Config\Financa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financa\Grupo\FinancaGrupoRequestStore;
use App\Http\Requests\Financa\Grupo\FinancaGrupoRequestUpdate;
use App\Http\Resources\Financa\Grupo\FinancaGrupoCollection;
use App\Http\Resources\Financa\Grupo\FinancaGrupoResource;
use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaGrupoModel;
use App\Models\Financa\FinancaTipoModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FinancaGrupoController extends Controller
{
  public function index()
  {
    try {
      // options
      $perPage = key_exists('perPage', $_GET) ? $_GET['perPage'] : 15;

      // model
      $where['usua_id'] = Auth::user()->id;
      if (key_exists('fngp_enable', $_GET)) $where['fngp_enable'] = $_GET['fngp_enable'];
      if (key_exists('fngp_fechamento', $_GET)) $where['fngp_fechamento'] = $_GET['fngp_fechamento'];
      if (key_exists('fnct_id', $_GET)) $where['fnct_id'] = $_GET['fnct_id'];
      if (key_exists('fntp_id', $_GET)) $where['fntp_id'] = $_GET['fntp_id'];

      $model = FinancaGrupoModel::where($where);

      if ($model->count()) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaGrupoCollection($model->paginate($perPage));
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

  public function store(FinancaGrupoRequestStore $request)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($request->fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $request->fnct_id) não existe!");

      // validate fntp_id
      $fntp_validate = FinancaTipoModel::find($request->fntp_id);
      if (!$fntp_validate) throw new \Exception("Tipo (fntp_id: $request->fntp_id) não existe!");


      // model
      $model = new FinancaGrupoModel;

      // array fields
      $fields = $request->only([
        'fngp_description', 'fngp_enable', 'fngp_fechamento', 'fntp_id', 'fnct_id'
      ]);
      $fields['usua_id'] = Auth::user()->id;

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaGrupoResource($model);
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function show($fngp_id)
  {
    try {
      // model
      $model = FinancaGrupoModel::find($fngp_id);

      if ($model) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaGrupoResource($model);
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

  public function update(FinancaGrupoRequestUpdate $request, $fngp_id)
  {
    try {
      // validate fngp_id
      $model = FinancaGrupoModel::find($fngp_id);
      if (!$model) throw new \Exception("Grupo (fngp_id: $fngp_id) não existe!");

      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($request->fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $request->fnct_id) não existe!");

      // validate fntp_id
      $fntp_validate = FinancaTipoModel::find($request->fntp_id);
      if (!$fntp_validate) throw new \Exception("Tipo (fntp_id: $request->fntp_id) não existe!");


      // array fields
      $fields = $request->only([
        'fngp_description', 'fngp_enable', 'fngp_fechamento', 'fntp_id', 'fnct_id'
      ]);
      $fields['usua_id'] = Auth::user()->id;

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaGrupoResource($model);
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
