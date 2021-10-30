<?php

namespace App\Http\Controllers\v1\Config\Financa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Financa\Carteira\FinancaCarteiraRequestStore;
use App\Http\Requests\Financa\Carteira\FinancaCarteiraRequestUpdate;
use App\Http\Resources\Financa\Carteira\FinancaCarteiraCollection;
use App\Http\Resources\Financa\Carteira\FinancaCarteiraResource;
use App\Models\Financa\FinancaCarteiraModel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinancaCarteiraController extends Controller
{
  public function index()
  {
    try {
      // options
      $per_page = key_exists('per_page', $_GET) ? $_GET['per_page'] : 15;

      // model
      $where['usua_id'] = Auth::user()->id;
      if (key_exists('fnct_enable', $_GET)) $where['fnct_enable'] = $_GET['fnct_enable'];
      if (key_exists('fnct_panel', $_GET)) $where['fnct_panel'] = $_GET['fnct_panel'];


      $model = FinancaCarteiraModel::where($where);

      if ($model->count()) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaCarteiraCollection($model->paginate($per_page));
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

  public function store(FinancaCarteiraRequestStore $request)
  {
    try {
      // model
      $model = new FinancaCarteiraModel;

      // array fields
      $fields = $request->only([
        'fnct_description', 'fnct_enable', 'fnct_json', 'fnct_panel'
      ]);
      $fields['usua_id'] = Auth::user()->id;

      // set values
      foreach ($fields as $key => $field) {
        $model->$key = $field;
      }

      // salve
      $model->save();

      $sts = Response::HTTP_CREATED;
      $rtn = new FinancaCarteiraResource($model);
    } catch (\Error $th) {

      $rtn = ['message' => "Error: {reset($th)}"];
      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return response()->json($rtn, $sts);
  }

  public function show($fnct_id)
  {
    try {
      // model
      $model = FinancaCarteiraModel::find($fnct_id);

      if ($model) {

        $sts = Response::HTTP_OK;
        $rtn = new FinancaCarteiraResource($model);
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

  public function update(FinancaCarteiraRequestUpdate $request, $fnct_id)
  {
    try {
      // model
      $model = FinancaCarteiraModel::find($fnct_id);

      if ($model) {
        // regras para deixar sempre uma carteira ativa em panel
        if ($request->fnct_panel == 1) {
          FinancaCarteiraModel::where(['usua_id' => Auth::user()->id, 'fnct_enable' => 1])->where('fnct_id', '!=', $fnct_id)->update(['fnct_panel' => 0]);
          $request->fnct_enable = 1;
        } else {
          $count = FinancaCarteiraModel::where(['usua_id' => Auth::user()->id, 'fnct_enable' => 1, 'fnct_panel' => 1])->where('fnct_id', '!=', $fnct_id)->count();
          if ($count == 0) {
            $request->fnct_panel = 1;
            $request->fnct_enable = 1;
          }
          // regras para deixar sempre uma carteira ativa em enable
          if ($request->fnct_enable == 0) {
            if ($count == 0) $request->fnct_enable = 1;
          }
        }

        // array fields
        $fields = $request->only([
          'fnct_description', 'fnct_enable', 'fnct_json', 'fnct_panel'
        ]);
        $fields['usua_id'] = Auth::user()->id;

        // set values
        foreach ($fields as $key => $field) {
          $model->$key = $field;
        }
        // salve
        $model->save();

        $sts = Response::HTTP_CREATED;
        $rtn = new FinancaCarteiraResource($model);
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

  // public function destroy($id)
  // {
  // }
}
