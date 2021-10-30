<?php

namespace App\Http\Controllers\v1\Financa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financa\Item\FinancaItemRequestStore;
use App\Http\Requests\Financa\Item\FinancaItemRequestUpdate;
use App\Http\Resources\Financa\Item\FinancaItemCollection;
use App\Http\Resources\Financa\Item\FinancaItemResource;
use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaCategoriaModel;
use App\Models\Financa\FinancaGrupoModel;
use App\Models\Financa\FinancaItemModel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinancaItemController extends Controller
{

  public function __construct()
  {
    $p =  explode(
      '-',
      key_exists('p', $_GET) ? $_GET['p'] : date('Y-m-d')
    );
    $this->p = now()->setYears($p[0])->setMonths($p[1]);
  }

  public function index($fnct_id)
  {
    try {
      // options
      $perPage = key_exists('per_page', $_GET) ? $_GET['per_page'] : 15;

      // model
      $where['fnct_id'] = $fnct_id;
      $where['usua_id'] = Auth::user()->id;
      if (key_exists('fngp_id', $_GET)) $where['fngp_id'] = $_GET['fngp_id'];
      if (key_exists('fncg_id', $_GET)) $where['fncg_id'] = $_GET['fncg_id'];
      if (key_exists('fntp_id', $_GET)) $where['fntp_id'] = $_GET['fntp_id'];
      if (key_exists('fnis_id', $_GET)) $where['fnis_id'] = $_GET['fnis_id'];
      if (key_exists('fnit_enable', $_GET)) $where['fnit_enable'] = $_GET['fnit_enable'];

      $model = FinancaItemModel::where($where);

      $orderBy = 'fnit_id desc';
      $queryExtrato      = key_exists('r', $_GET) && $_GET['r'] == 'extrato';
      $queryHistorico    = key_exists('r', $_GET) && $_GET['r'] == 'historico';
      $queryMovimentacao = key_exists('r', $_GET) && $_GET['r'] == 'movimentacao';

      if ($queryExtrato) {
        $orderBy = 'fnis_id desc, fnit_date desc';
        $model->whereYear('fnit_date', $this->p->format('Y'))->whereMonth('fnit_date', $this->p->format('m'));
      }
      if ($queryHistorico) {
        $orderBy = 'fnit_id desc';
      }
      if ($queryMovimentacao) {
        $orderBy = 'fnit_date desc';
        $model->where('fnit_date', '<=', $this->p->format('Y-m-d'));
      }


      if ($model->count()) {
        $model->orderByRaw($orderBy);

        $sts = Response::HTTP_OK;
        $rtn = new FinancaItemCollection($model->paginate($perPage));
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

  public function store(FinancaItemRequestStore $request, $fnct_id)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $request->fnct_id) não existe!");

      // validate fnct_id
      $fngp_validate = FinancaGrupoModel::find($request->fngp_id);
      if (!$fngp_validate) throw new \Exception("Grupo (fngp_id: $request->fngp_id) não existe!");

      // validate fnct_id
      $fncg_validate = FinancaCategoriaModel::find($request->fncg_id);
      if (!$fncg_validate) throw new \Exception("Categoria (fncg_id: $request->fncg_id) não existe!");

      // model
      $model = new FinancaItemModel();

      // array fields
      $fields = $request->only([
        'fnit_value', 'fnit_date', 'fnit_obs', 'fnit_enable', 'fnis_id', 'fntp_id', 'fngp_id', 'fncg_id'
      ]);
      $fields['usua_id'] = Auth::user()->id;
      $fields['fnct_id'] = $fnct_id;

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaItemResource($model);
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function show($fnct_id, $fnit_id)
  {
    try {
      // model
      $model = FinancaItemModel::where([
        'fnct_id' => $fnct_id,
        'fnit_id' => $fnit_id,
      ])->first();

      if ($model) {
        $sts = Response::HTTP_OK;
        $rtn = new FinancaItemResource($model);
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

  public function update(FinancaItemRequestUpdate $request, $fnct_id, $fnit_id)
  {
    try {
      // model
      $model = FinancaItemModel::where('fnct_id', $fnct_id)->where('fnit_id', $fnit_id);

      if (!$model->count()) throw new \Exception("Item (fnit_id: $fnit_id) não existe!");

      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $fnct_id) não existe!");

      // validate fnct_id
      $fngp_validate = FinancaGrupoModel::find($request->fngp_id);
      if (!$fngp_validate) throw new \Exception("Grupo (fngp_id: $request->fngp_id) não existe!");

      // validate fnct_id
      $fncg_validate = FinancaCategoriaModel::find($request->fncg_id);
      if (!$fncg_validate) throw new \Exception("Categoria (fncg_id: $request->fncg_id) não existe!");


      // array fields
      $fields = $request->only([
        'fnit_value', 'fnit_date', 'fnit_obs', 'fnit_enable', 'fnis_id', 'fntp_id', 'fngp_id', 'fncg_id'
      ]);

      // set values
      // foreach ($fields as $key => $field) {
      //   $model->$key = $field;
      // }

      // salve
      $model->update(
        array_merge(
          $fields,
          [
            'fnit_enable' => $fields['fnit_enable'] ? "1" : "0"
          ]
        )
      );

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaItemResource($model->first());
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}"];
    }

    return response()->json($rtn, $sts);
  }

  public function destroy($fnct_id, $fnit_id)
  {
    try {
      // model
      $model = FinancaItemModel::find($fnit_id);
      if (!$model) throw new \Exception("Item (fnit_id: $fnit_id) não existe!");

      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $fnct_id) não existe!");

      // delete
      $model->delete();

      $sts = Response::HTTP_NO_CONTENT;
      $rtn = null;
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
      $rtn = ['message' => "Error: {reset($th)}", 'data' => null];
    }

    return response()->json($rtn, $sts);
  }
}
