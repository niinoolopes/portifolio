<?php

namespace App\Http\Controllers\v1\Financa;

use App\Http\Controllers\Controller;
use App\Http\Resources\Financa\Item\FinancaItemResource;
use App\Models\Financa\FinancaItemModel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FinancaAnaliseItemController extends Controller
{
  public function __construct()
  {
    if (key_exists('p', $_GET)) {
      $p =  explode('-', $_GET['p']);
      $this->p = now()->setYears($p[0])->setMonths($p[1]);
    }
  }

  public function grupoCategoria($fnct_id, $fntp_id, $fngp_id = false, $fncg_id = false)
  {
    try {
      // validate periodo
      if (!isset($this->p)) throw new \Exception("Periodo não informado!");

      $where = [];
      $where['usua_id'] = Auth::user()->id;
      $where['fnct_id'] = $fnct_id;
      $where['fnis_id'] = 1;
      $where['fnit_enable'] = 1;
      $where['fntp_id'] = $fntp_id;
      if ($fngp_id) $where['fngp_id'] = $fngp_id;
      if ($fncg_id) $where['fncg_id'] = $fncg_id;

      $arr = FinancaItemModel::with(['fntp', 'fnis', 'fngp', 'fncg'])->whereYear('fnit_date', $this->p)->where($where)->get();

      if (!!$arr->count()) {
        $arr->toArray();

        $items = [];
        $valoresMes = [];
        $valoresPie = [
          'label' => [],
          'value' => [],
        ];


        for ($i = 1; $i <= 12; $i++) {
          $index = str_pad($i, 2, '0', STR_PAD_LEFT);

          $mesNum = strftime('%m', strtotime("2021-{$index}-01"));
          $mesName = utf8_encode(
            strtolower(
              strftime('%B', strtotime("2021-{$index}-01"))
            )
          );

          $items[$index] = [
            'name' => $mesName,
            "items" => [],
          ];

          $valoresMes[$index] = [
            'name' => $mesName,
            'value' => 0
          ];

          $valoresPie['label'][$mesNum] = $mesName;
          $valoresPie['value'][$mesNum] = 0;
        }

        foreach ($arr as $key => $item) {
          $mesNum = strftime('%m', strtotime($item->fnit_date));

          // add items
          $items[$mesNum]['items'][] = new FinancaItemResource($item);


          // soma valor mes
          $valoresMes[$mesNum]['value'] += $item->fnit_value;
          $valoresPie['value'][$mesNum] += $item->fnit_value;

          unset($arr[$key], $key);
        }

        ksort($items);
        ksort($valoresMes);


        $valoresMes = array_map(function ($item) {
          $item['value'] = (float)number_format($item['value'], 2, '.', '');
          return $item;
        }, array_values($valoresMes));

        $valoresPie['value'] = array_map(function ($value) {
          return (float)number_format($value, 2, '.', '');
        }, array_values($valoresPie['value']));


        $sts = Response::HTTP_OK;
        $rtn = [
          'items'      => array_values($items),
          'valoresMes' => array_values($valoresMes),
          'valoresPie' => [
            'label' => array_values($valoresPie['label']),
            'value' => array_values($valoresPie['value']),
          ]
        ];
      } else {
        $sts = Response::HTTP_NO_CONTENT;
        $rtn = null;
      }
    } catch (\Exception  $e) {

      $sts = Response::HTTP_FAILED_DEPENDENCY;
      $rtn = ['message' => $e->getMessage()];
    } catch (\Error $th) {

      $rtn = ['message' => "Error: {reset($th)}"];
      $sts = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    return response()->json($rtn, $sts);
  }

  public function analiseAno($fnct_id, $fntp_id = false, $fngp_id = false, $fncg_id = false)
  {
    try {
      // validate periodo
      if (!isset($this->p)) throw new \Exception("Periodo não informado!");

      $where = [];
      $where['usua_id'] = Auth::user()->id;
      $where['fnct_id'] = $fnct_id;
      $where['fnis_id'] = 1;
      $where['fnit_enable'] = 1;
      if ($fntp_id) $where['fntp_id'] = $fntp_id;
      if ($fngp_id) $where['fngp_id'] = $fngp_id;
      if ($fncg_id) $where['fncg_id'] = $fncg_id;

      $arr = FinancaItemModel::with(['fntp', 'fnis', 'fngp', 'fncg'])->whereYear('fnit_date', $this->p)->where($where)->get();

      if (!!$arr->count()) {
        $arr->toArray();


        $headers = ['Origem', 'Total'];
        $mesesBase = [];
        $items = [
          'fntp' => [],
          'fngp' => [],
          'fncg' => [],
        ];

        for ($i = 1; $i <= 12; $i++) {
          $index = str_pad($i, 2, '0', STR_PAD_LEFT);

          $mesNum = strftime('%m', strtotime("2021-{$index}-01"));
          $mesName = utf8_encode(
            strtolower(
              strftime('%B', strtotime("2021-{$index}-01"))
            )
          );

          $headers[] = $mesName;
          $mesesBase[$mesNum] = 0;
        }

        foreach ($arr as $key => $item) {
          $fnit_date = $item->fnit_date;
          $fnit_value = $item->fnit_value;

          $mesNum = strftime('%m', strtotime($fnit_date));

          $aliasNames = [
            'fntp' => $item['fntp']['fntp_description'],
            'fngp' => $item['fngp']['fngp_description'],
            'fncg' => substr($item['fngp']['fngp_description'], 0, 5) . '. ' . $item['fncg']['fncg_description'],
          ];

          foreach (['fntp', 'fngp', 'fncg'] as $type) {
            $aliasName = $aliasNames[$type];

            if (!key_exists($aliasName, $items[$type])) {
              // add meses base
              $items[$type][$aliasName] = $mesesBase;
              // add name
              $items[$type][$aliasName]["0"] = $aliasName;
              $items[$type][$aliasName]["00"] = 0;
              // sort
              ksort($items[$type][$aliasName]);
              ksort($items[$type]);
            }

            // soma valor mes
            $items[$type][$aliasName][$mesNum] += $fnit_value;
          }
          unset($arr[$key], $key, $item, $fnit_date, $fnit_value, $mesNum, $aliasNames, $type);
        }
        unset($arr);

        // 

        foreach ($items as $keyTypes => $types) {
          foreach ($types as $keyType => $item) {
            // get values
            $values = array_values($item);

            // get values corespondente aos meses
            $valuesMeses = array_slice($values, 2, 12);

            // atribuição
            $items[$keyTypes][$keyType] = $values;

            // soma os meses e atribui para posição de TOTAL
            $items[$keyTypes][$keyType][1] = array_sum($valuesMeses);
          }
          $items[$keyTypes] = array_values($items[$keyTypes]);
        }

        $sts = Response::HTTP_OK;
        $rtn = [
          "fntp" => $items['fntp'],
          "fngp" => $items['fngp'],
          "fncg" => $items['fncg'],
        ];
      } else {
        $sts = Response::HTTP_NO_CONTENT;
        $rtn = null;
      }
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
