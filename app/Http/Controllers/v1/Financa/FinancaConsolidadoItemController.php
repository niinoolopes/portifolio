<?php

namespace App\Http\Controllers\v1\Financa;

use App\Http\Controllers\Controller;
use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaConsolidadoItemMonthModel;
use App\Models\Financa\FinancaConsolidadoItemYearModel;
use App\Models\Financa\FinancaItemModel;
use Symfony\Component\HttpFoundation\Response;

class FinancaConsolidadoItemController extends Controller
{

  public function __construct()
  {
    if (key_exists('p', $_GET)) {
      $p =  explode('-', $_GET['p']);
      $this->p = now()->setYears($p[0])->setMonths($p[1]);
    }
  }

  public function consolidate($fnct_id)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $fnct_id) não existe!");

      // consolidar
      $this->consolidation(
        $fnct_id,
        isset($this->p) ? date('Y-m', strtotime($this->p)) : ''
      );

      $sts = Response::HTTP_OK;
      $rtn = [
        'message' => "Items consolidados",
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

  public function consolidateMonth($fnct_id)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $fnct_id) não existe!");

      // validate periodo
      if (!$this->p) throw new \Exception("Periodo não informado!");


      $explode = explode('-', $this->p);
      $year =  $explode[0];
      $month =  $explode[1];

      $where['fncim_year'] = $year;
      $where['fncim_month'] = $month;
      $where['fnct_id'] = $fnct_id;
      $model = FinancaConsolidadoItemMonthModel::where($where)->first();

      // retornos defauts
      $saldo = [
        'receita' => 0,
        'despesa' => 0,
        'sobra' => 0,
        'estimado' => 0,
      ];
      $saldoPie = ['label' => [], 'value' => []];

      $fntpArr = [];
      $fntpPie = ['label' => [], 'value' => []];

      $fngpArr = [];
      $fngpReceita = [];
      $fngpDespesa = [];
      $fngpReceitaMax = [];
      $fngpDespesaMax = [];
      $fngpReceitaPie = ['label' => [], 'value' => []];
      $fngpDespesaPie = ['label' => [], 'value' => []];

      $fncgArr = [];
      $fncgReceita = [];
      $fncgDespesa = [];
      $fncgReceitaMax = [];
      $fncgDespesaMax = [];
      $fncgReceitaPie = ['label' => [], 'value' => []];
      $fncgDespesaPie = ['label' => [], 'value' => []];


      if ($model) {

        $fncim_json = (array) json_decode($model->fncim_json);

        // acesso e order em items FNGP
        $fngpArr = $fncim_json['fngp'];
        array_multisort(array_column($fngpArr, 'name'), SORT_ASC, $fngpArr);

        // acesso e order em items FNCG
        $fncgArr = $fncim_json['fncg'];
        array_multisort(array_column($fncgArr, 'name'), SORT_ASC, $fncgArr);

        // acesso e order em items FNTP
        $fntpArr = $fncim_json['fntp'];
        array_multisort(array_column($fntpArr, 'name'), SORT_ASC, $fntpArr);


        // set values
        $saldo['receita'] = $fncim_json['receita'];
        $saldo['despesa'] = $fncim_json['despesa'];
        $saldo['sobra'] = $fncim_json['sobra'];
        $saldo['estimado'] = $fncim_json['estimado'];

        $saldoPie['label'][] = "Receita";
        $saldoPie['label'][] = "Despesa";
        $saldoPie['label'][] = "Sobra";
        $saldoPie['label'][] = "Estimado";
        $saldoPie['value'][] = $fncim_json['receita'];
        $saldoPie['value'][] = $fncim_json['despesa'];
        $saldoPie['value'][] = $fncim_json['sobra'];
        $saldoPie['value'][] = $fncim_json['estimado'];

        $fntpPie['label'][] = "Receita";
        $fntpPie['label'][] = "Despesa";
        $fntpPie['value'][] = $fncim_json['receita'];
        $fntpPie['value'][] = $fncim_json['despesa'];


        foreach ($fngpArr as $item) {
          if ($item->fntp === 1) {
            $fngpReceita[] = $item;
            $fngpReceitaPie['label'][] = $item->name;
            $fngpReceitaPie['value'][] = $item->total;
          }
          if ($item->fntp === 2) {
            $fngpDespesa[] = $item;
            $fngpDespesaPie['label'][] = $item->name;
            $fngpDespesaPie['value'][] = $item->total;
          }
        }

        foreach ($fncgArr as $item) {
          if ($item->fntp === 1) {
            $fncgReceita[] = $item;
            $fncgReceitaPie['label'][] = $item->name;
            $fncgReceitaPie['value'][] = $item->total;
          }
          if ($item->fntp === 2) {
            $fncgDespesa[] = $item;
            $fncgDespesaPie['label'][] = $item->name;
            $fncgDespesaPie['value'][] = $item->total;
          }
        }

        
        // acesso e order em items FNGP
        $fngpArr = $fncim_json['fngp'];
        array_multisort(array_column($fngpArr, 'total'), SORT_DESC, $fngpArr);
        // filtro para usar apenas GRRUPOS
        $fngpArrReceita = array_filter($fngpArr, function($item){ return $item->fntp === 1; });
        $fngpArrDespesa = array_filter($fngpArr, function($item){ return $item->fntp === 2; });
        // splice para usar apenas os 3 primeiros items
        $fngpReceitaMax = array_splice($fngpArrReceita, 0, 3);
        $fngpDespesaMax = array_splice($fngpArrDespesa, 0, 3);


        // acesso e order em items FNCG
        $fncgArr = $fncim_json['fncg'];
        array_multisort(array_column($fncgArr, 'total'), SORT_DESC, $fncgArr);
        // filtro para usar apenas CATEGORIAS
        $fncgArrReceita = array_filter($fncgArr, function($item){ return $item->fntp === 1; });
        $fncgArrDespesa = array_filter($fncgArr, function($item){ return $item->fntp === 2; });
        // splice para usar apenas os 3 primeiros items
        $fncgReceitaMax = array_splice($fncgArrReceita, 0, 3);
        $fncgDespesaMax = array_splice($fncgArrDespesa, 0, 3);


        $sts = Response::HTTP_OK;
        $rtn = [
          'message' => "Consolidado mês encontrado",
          "saldo" => $saldo,
          "saldoPie" => $saldoPie,

          "fntp" => $fntpArr,
          "fntpPie" => $fntpPie,

          "fngpReceita" => $fngpReceita,
          "fngpDespesa" => $fngpDespesa,
          "fngpReceitaMax" => $fngpReceitaMax,
          "fngpDespesaMax" => $fngpDespesaMax,
          "fngpReceitaPie" => $fngpReceitaPie,
          "fngpDespesaPie" => $fngpDespesaPie,

          "fncgReceita" => $fncgReceita,
          "fncgDespesa" => $fncgDespesa,
          "fncgReceitaMax" => $fncgReceitaMax,
          "fncgDespesaMax" => $fncgDespesaMax,
          "fncgReceitaPie" => $fncgReceitaPie,
          "fncgDespesaPie" => $fncgDespesaPie,
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

  public function consolidateYear($fnct_id)
  {
    try {
      // validate fnct_id
      $fnct_validate = FinancaCarteiraModel::find($fnct_id);
      if (!$fnct_validate) throw new \Exception("Carteira (fnct_id: $fnct_id) não existe!");

      // validate periodo
      if (!$this->p) throw new \Exception("Periodo não informado!");


      $explode = explode('-', $this->p);
      $year =  $explode[0];

      $where['fnciy_year'] = $year;
      $where['fnct_id'] = $fnct_id;
      $model = FinancaConsolidadoItemYearModel::where($where)->first();

      // retornos defauts
      $saldo = [
        'receita' => 0,
        'despesa' => 0,
        'sobra' => 0,
        'estimado' => 0,
      ];
      $saldoPie = ['label' => [], 'value' => []];

      $fntpArr = [];
      $fntpPie = ['label' => [], 'value' => []];

      $fngpArr = [];
      $fngpReceita = [];
      $fngpDespesa = [];
      $fngpReceitaPie = ['label' => [], 'value' => []];
      $fngpDespesaPie = ['label' => [], 'value' => []];

      $fncgArr = [];
      $fncgReceita = [];
      $fncgDespesa = [];
      $fncgReceitaPie = ['label' => [], 'value' => []];
      $fncgDespesaPie = ['label' => [], 'value' => []];


      if ($model) {

        $fnciy_json = (array) json_decode($model->fnciy_json);


        // acesso e order em items FNGP
        $fngpArr = $fnciy_json['fngp'];
        array_multisort(array_column($fngpArr, 'name'), SORT_ASC, $fngpArr);

        // acesso e order em items FNCG
        $fncgArr = $fnciy_json['fncg'];
        array_multisort(array_column($fncgArr, 'name'), SORT_ASC, $fncgArr);

        // acesso e order em items FNTP
        $fntpArr = $fnciy_json['fntp'];
        array_multisort(array_column($fntpArr, 'name'), SORT_ASC, $fntpArr);


        // set values
        $saldo['receita']  = number_format($fnciy_json['receita'], 2, ',', '.');
        $saldo['despesa']  = number_format($fnciy_json['despesa'], 2, ',', '.');
        $saldo['sobra']    = number_format($fnciy_json['sobra'], 2, ',', '.');
        $saldo['estimado'] = number_format($fnciy_json['estimado'], 2, ',', '.');

        $saldoPie['label'][] = "Receita";
        $saldoPie['label'][] = "Despesa";
        $saldoPie['label'][] = "Sobra";
        $saldoPie['label'][] = "Estimado";
        $saldoPie['value'][] = number_format($fnciy_json['receita'], 2, ',', '.');
        $saldoPie['value'][] = number_format($fnciy_json['despesa'], 2, ',', '.');
        $saldoPie['value'][] = number_format($fnciy_json['sobra'], 2, ',', '.');
        $saldoPie['value'][] = number_format($fnciy_json['estimado'], 2, ',', '.');

        $fntpPie['label'][] = "Receita";
        $fntpPie['label'][] = "Despesa";
        $fntpPie['value'][] = number_format($fnciy_json['receita'], 2, ',', '.');
        $fntpPie['value'][] = number_format($fnciy_json['despesa'], 2, ',', '.');

        foreach ($fngpArr as $item) {
          if ($item->fntp === 1) {
            $fngpReceita[] = $item;
            $fngpReceitaPie['label'][] = $item->name;
            $fngpReceitaPie['value'][] = $item->total;
          }
          if ($item->fntp === 2) {
            $fngpDespesa[] = $item;
            $fngpDespesaPie['label'][] = $item->name;
            $fngpDespesaPie['value'][] = $item->total;
          }
        }

        foreach ($fncgArr as $item) {
          if ($item->fntp === 1) {
            $fncgReceita[] = $item;
            $fncgReceitaPie['label'][] = $item->name;
            $fncgReceitaPie['value'][] = $item->total;
          }
          if ($item->fntp === 2) {
            $fncgDespesa[] = $item;
            $fncgDespesaPie['label'][] = $item->name;
            $fncgDespesaPie['value'][] = $item->total;
          }
        }

        $sts = Response::HTTP_OK;
        $rtn = [
          'message' => "Consolidado ano encontrado",
          "saldo" => $saldo,
          "saldoPie" => $saldoPie,

          "fntp" => $fntpArr,
          "fntpPie" => $fntpPie,

          "fngpReceita" => $fngpReceita,
          "fngpDespesa" => $fngpDespesa,
          "fngpReceitaPie" => $fngpReceitaPie,
          "fngpDespesaPie" => $fngpDespesaPie,

          "fncgReceita" => $fncgReceita,
          "fncgDespesa" => $fncgDespesa,
          "fncgReceitaPie" => $fncgReceitaPie,
          "fncgDespesaPie" => $fncgDespesaPie,
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

  // AUX
  public function consolidation($fnct_id, $mes = false)
  {
    $periodos = [];

    // $carteira = FinancaCarteiraModel::find($fnct_id)->toArray();
    // $this->fnct_json = json_decode($carteira['fnct_json']);

    ## PERIODO
    if ($mes) {
      // mes que ira ser consolidado
      $periodos[] = $mes;
    } else {

      // apaga todos os consolidados para refazer
      // FinancaItemConsolidadoModel::where(['fnct_id' => $fnct_id])->delete();

      // busca todos os meses para consolidar 
      $periodos = FinancaItemModel::orderBy('fnit_date', 'ASC')
        ->where([
          'fnct_id' => $fnct_id
        ])
        ->distinct()
        ->groupBy('fnit_date')
        ->get(['fnit_date'])
        ->toArray();

      // retorna apenas o value de cara item composto por "item => ['fnit_date' => data]"
      foreach ($periodos as $key => $value) {
        $fnit_date = $value['fnit_date'];

        $key_date = date('Y-m', strtotime($fnit_date));

        $isKey = key_exists($key_date, $periodos) ? true : false;

        if (!$isKey) {
          $periodos[$key_date] = $fnit_date;
        }

        unset($fnit_date, $key_date, $isKey, $periodos[$key]);
      }
      unset($key, $value);

      // sort
      ksort($periodos, SORT_STRING);

      $periodos = array_values($periodos);
    }
    ## PERIODO -- FIM


    if (count($periodos) == 0) {
      return false;
    }


    ## AGRUPA MESES AO ANO
    foreach ($periodos as $key => $date) {
      $explode = explode('-', $date);
      $year =  $explode[0];
      $month =  $explode[1];

      $periodos[$year][] = $month;

      unset($explode, $year, $month, $periodos[$key], $key, $date,);
    }
    ## AGRUPA MESES AO ANO -- FIM


    foreach ($periodos as $year => $months) {

      $json_year = [
        'receita'  => 0,
        'despesa'  => 0,
        'sobra'    => 0,
        'estimado' => 0,
        'fngp'     => [],
        'fncg'     => [],
        'fntp'     => [],
        'fngp_grafico' => [],
        'fncg_grafico' => [],
        'fntp_grafico' => [],
      ];

      foreach ($months as $key_month => $month) {

        $json_month = [
          'receita'  => 0,
          'despesa'  => 0,
          'sobra'    => 0,
          'estimado' => 0,
          'fngp'     => [],
          'fncg'     => [],
          'fntp'     => [],
          'fngp_grafico' => [],
          'fncg_grafico' => [],
          'fntp_grafico' => [],
        ];

        // cria o date que o eloquent lê
        $date = now()->setYears($year)->setMonths($month);

        // model
        $items = (new FinancaItemModel())::with(['fntp', 'fnis', 'fngp', 'fncg'])
          ->whereYear('fnit_date', $date)
          ->whereMonth('fnit_date', $date)
          ->where([
            'fnct_id' => $fnct_id,
            'fnit_enable' => 1
          ])
          ->get()
          ->toArray();


        // SOMA VALORES/MES
        foreach ($items as $item) {
          $fntp_id = $item['fntp_id'];
          $fnis_id = $item['fnis_id'];

          if (($fntp_id == 1)) {
            $json_month['receita'] += $item['fnit_value'];
            $json_year['receita']  += $item['fnit_value'];
          }

          if (($fntp_id == 2)) {
            $json_month['despesa'] += $item['fnit_value'];
            $json_year['despesa']  += $item['fnit_value'];
          }

          if ($fnis_id == 1) {
            $json_month['estimado'] = $json_month['receita'] - $json_month['despesa'];
            $json_year['estimado'] = $json_year['receita'] - $json_year['despesa'];
          }

          $json_month['sobra'] = $json_month['receita'] - $json_month['despesa'];
          $json_year['sobra']  = $json_year['receita'] - $json_year['despesa'];

          sleep(0.5);
        }

        // FORMAT VALORES/MES
        foreach (['receita', 'despesa', 'sobra', 'estimado'] as $key) {
          $json_month[$key] = number_format($json_month[$key], 2, '.', '');
        }
        unset($key);


        // APURA VALORES
        foreach ($items as $key_item => $item) {

          // pago - pendente - talvez
          $fnis_name = strtolower($item['fnis']['fnis_description']);

          foreach (['fngp', 'fncg', 'fntp'] as $key) {
            $id = $item["{$key}_id"];

            if (key_exists($id, $json_month[$key]) == false) {
              $json_month[$key][$id] = [
                'id'         => '',
                'name'       => '',
                'fntp'       => 0,
                'total'      => 0,
                'percentual' => 0,
                'pago'       => 0,
                'pendente'   => 0,
                'talvez'     => 0,
                // 'divisao_total'      => 0,
                // 'divisao_percentual' => 0,
                // 'divisao_compatible' => 0,
              ];;

              $json_month[$key][$id]['id']   = $id;
              $json_month[$key][$id]['name'] = $item[$key]["{$key}_description"];
              $json_month[$key][$id]['fngp'] = null;
              $json_month[$key][$id]['fncg'] = null;
              $json_month[$key][$id]['fntp'] = $item["fntp_id"];

              if ($key !== 'fntp') {
                $json_month[$key][$id]['fngp'] = $item["fngp_id"];
                $json_month[$key][$id]['fncg'] = $item["fncg_id"];
              }
            }


            if (key_exists($id, $json_year[$key]) == false) {
              $json_year[$key][$id] = [
                'id'         => '',
                'name'       => '',
                'fntp'       => 0,
                'total'      => 0,
                'percentual' => 0,
                'pago'       => 0,
                'pendente'   => 0,
                'talvez'     => 0,
              ];;

              $json_year[$key][$id]['id']   = $id;
              $json_year[$key][$id]['name'] = $item[$key]["{$key}_description"];
              $json_year[$key][$id]['fngp'] = null;
              $json_year[$key][$id]['fncg'] = null;
              $json_year[$key][$id]['fntp'] = $item["fntp_id"];

              if ($key !== 'fntp') {
                $json_year[$key][$id]['fngp'] = $item["fngp_id"];
                $json_year[$key][$id]['fncg'] = $item["fncg_id"];
              }
            }

            $json_month[$key][$id]['total']    += $item['fnit_value'];
            $json_month[$key][$id][$fnis_name] += $item['fnit_value'];

            $json_year[$key][$id]['total']    += $item['fnit_value'];
            $json_year[$key][$id][$fnis_name] += $item['fnit_value'];


            # DIVISÃO 
            // $key_obj = "{$key}_attr";

            // identifica a divisao configurada para usar
            // $divisao_value = isset($this->fnct_json->$key_obj->$id)
            //   ? $this->fnct_json->$key_obj->$id
            //   : 0;

            // identifica o total para usar
            // $total = ($item['fntp_id'] == 1)
            //   ? +$json_month['receita']
            //   : +$json_month['despesa'];

            // encontra o valor esperado da divisão de metas
            // $json_month[$key][$id]['divisao_total']      = +number_format(($total * $divisao_value) / 100, 2, '.', '');
            // grava divisão configurada 
            // $json_month[$key][$id]['divisao_percentual'] = $divisao_value;
            // valida se o valor TOTAL é menor ou igual ao valor DIVISÃO TOTAL (valor esperado)
            // $json_month[$key][$id]['divisao_compatible'] = +$json_month[$key][$id]['total'] <= $json_month[$key][$id]['divisao_total'] ? true : false;
            unset($key);
          }

          unset($items[$key_item], $key_item, $item);
          sleep(0.5);
        }
        unset($items);


        foreach (['fngp', 'fncg', 'fntp'] as $key) {
          $tmp = array_values($json_month[$key]);
          array_multisort(array_column($tmp, 'name'), SORT_ASC, $tmp);

          // calcula o percentual de cada item da list
          foreach ($tmp as $key_item => $item) {
            $percentual = 0;

            if ($item['fntp'] == 1 && $json_month['receita'] > 0) {
              $percentual = $item['total'] / $json_month['receita'];
            } else if ($item['fntp'] == 2 && $json_month['despesa'] > 0) {
              $percentual = $item['total'] / $json_month['despesa'];
            }

            $percentual *= 100;

            $tmp[$key_item]['fntp']       = $item["fntp"];
            $tmp[$key_item]['pago']       = number_format($tmp[$key_item]['pago'], 2, '.', '');
            $tmp[$key_item]['pendente']   = number_format($tmp[$key_item]['pendente'], 2, '.', '');
            $tmp[$key_item]['talvez']     = number_format($tmp[$key_item]['talvez'], 2, '.', '');
            $tmp[$key_item]['total']      = number_format($tmp[$key_item]['total'], 2, '.', '');
            $tmp[$key_item]['percentual'] = number_format($percentual, 4, '.', '');
          }

          $json_month[$key] = $tmp;
          $json_month["{$key}_grafico"] = array_map(function ($item) {
            return [
              'fntp'  => $item['fntp'],
              'label' => $item['name'],
              'value' => $item['total'],
            ];
          }, $tmp);

          sleep(0.1);
        }

        // atualiza ou insere consolidado/month
        FinancaConsolidadoItemMonthModel::updateOrCreate(
          // campos de comparação
          [
            'fncim_year' => $year,
            'fncim_month' => $month,
            'fnct_id'   => $fnct_id,
          ],
          // campos de gravação
          [
            'fncim_json' => json_encode($json_month)
          ]
        );

        unset($months[$key_month], $key_month, $month);
        sleep(0.5);
      }


      // ordenação array list por 'name'
      foreach (['fngp', 'fncg', 'fntp'] as $key) {
        $tmp = array_values($json_year[$key]);
        array_multisort(array_column($tmp, 'name'), SORT_ASC, $tmp);

        // calcula o percentual de cada item da list
        foreach ($tmp as $key_item => $item) {
          $tmp[$key_item]['fntp']       = $item["fntp"];
          $tmp[$key_item]['pago']       = number_format($tmp[$key_item]['pago'], 2, '.', '');
          $tmp[$key_item]['pendente']   = number_format($tmp[$key_item]['pendente'], 2, '.', '');
          $tmp[$key_item]['talvez']     = number_format($tmp[$key_item]['talvez'], 2, '.', '');
          $tmp[$key_item]['total']      = number_format($tmp[$key_item]['total'], 2, '.', '');
        }

        $json_year[$key] = $tmp;
        $json_year["{$key}_grafico"] = array_map(function ($item) {
          return [
            'fntp'  => $item['fntp'],
            'label' => $item['name'],
            'value' => $item['total'],
          ];
        }, $tmp);

        sleep(0.1);
      }


      // atualiza ou insere consolidado/year
      FinancaConsolidadoItemYearModel::updateOrCreate(
        // campos de comparação
        [
          'fnciy_year' => $year,
          'fnct_id'   => $fnct_id,
        ],
        // campos de gravação
        [
          'fnciy_json' => json_encode($json_year)
        ]
      );

      unset($periodos[$year], $year, $months);
      sleep(0.5);
    }

    unset($periodos);
    sleep(0.5);
  }
}
