<?php

namespace App\Http\Controllers\Financa;

use App\Http\Controllers\Controller;
use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaItemConsolidadoModel;
use App\Models\Financa\FinancaItemModel;
use Illuminate\Http\Request;

class FinancaItemConsolidadoController extends Controller
{
  public function index()
  {
    //
  }

  public function store(Request $request)
  {
    //
  }

  public function show($id)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }

  public function consolidar($fnct_id, $mes = false)
  {
    $carteira = FinancaCarteiraModel::find($fnct_id)->toArray();
    // $this->fnct_json = json_decode($carteira['fnct_json']);

    // get periodos
    $this->getPeriodos($fnct_id, $mes);

    foreach ($this->periodos as $periodo) {
      // utiliza ano e mes das datas do formato 'YYYY-mm-dd'
      $p =  explode('-', $periodo);

      // cria o periodo que o eloquent lê
      $periodo = now()->setYears($p[0])->setMonths($p[1]);

      $model = new FinancaItemModel();

      $items = $model::with(['fntp', 'fnis', 'fngp', 'fncg'])
        ->whereYear('fnit_date', $periodo)
        ->whereMonth('fnit_date', $periodo)
        ->where(['fnct_id' => $fnct_id, 'fnit_enable' => 1])->get()->toArray();

      $json_data = $this->formatData($items);

      // atualiza ou insere os registros gerados
      FinancaItemConsolidadoModel::updateOrCreate(
        // campos de comparação
        [
          'fnic_date' => date('Y-m', strtotime($periodo)) . "-01 00:00:00",
          'fnct_id'   => $fnct_id,
        ],
        // campos de gravação
        [
          'fnic_json' => json_encode($json_data)
        ]
      );
    }

    unset($periodos, $periodo, $fnis_name);
    sleep(0.5);
  }

  public function getPeriodos($fnct_id, $mes)
  {
    $this->periodos = [];

    if ($mes) {
      // mes que ira ser consolidado
      $this->periodos[] = $mes;
    } else {

      // apaga todos os consolidados para refazer
      FinancaItemConsolidadoModel::where(['fnct_id' => $fnct_id])->delete();

      // busca todos os meses para consolidar 
      $this->periodos = FinancaItemModel::distinct()->orderBy('fnit_date', 'ASC')->get(['fnit_date'])->toArray();

      // retorna apenas o value de cara item composto por "item => ['fnit_date' => data]"
      $this->periodos = array_map(function ($data) {
        return $data['fnit_date'];
      }, $this->periodos);
    }
  }

  public function mergeData($items)
  {
    // base de retorno
    $data = [
      "fnic_id"   => [],
      'fnic_date' => [],
      'fnic_json' => [
        'receita'  => 0,
        'despesa'  => 0,
        'sobra'    => 0,
        'estimado' => 0,
        'fngp'     => [],
        'fncg'     => [],
        'fntp'     => [],
      ],
    ];

    // retorna base de retorno quando não encontrar tiver dados para agrupar
    if (count($items) > 0) {

      // agrupa valores 
      foreach ($items as $key => $value) {
        $fnic_json = (array)json_decode($value['fnic_json']);

        // array com meses
        $data['fnic_id'][]   = $value['fnic_id'];
        $data['fnic_date'][] = $value['fnic_date'];
        // soma de valores 
        $data['fnic_json']['receita']  += $fnic_json['receita'];
        $data['fnic_json']['despesa']  += $fnic_json['despesa'];
        $data['fnic_json']['sobra']    += $fnic_json['sobra'];
        $data['fnic_json']['estimado'] += $fnic_json['estimado'];

        foreach (['fngp', 'fncg', 'fntp'] as $key) {
          foreach ($fnic_json[$key] as $item) {

            // monta retorno inicial
            if (!isset($data['fnic_json'][$key][$item->id])) {

              $data['fnic_json'][$key][$item->id] = [
                'id'         => $item->id,
                'name'       => $item->name,
                'fngp'       => $item->fngp,
                'fncg'       => $item->fncg,
                'fntp'       => $item->fntp,
                'total'      => 0,
                'percentual' => 0,
                'pago'       => 0,
                'pendente'   => 0,
                'talvez'     => 0,
              ];
            }

            // soma de valores 
            $data['fnic_json'][$key][$item->id]["total"]      += $item->total;
            $data['fnic_json'][$key][$item->id]["percentual"] += $item->percentual;
            $data['fnic_json'][$key][$item->id]["pago"]       += $item->pago;
            $data['fnic_json'][$key][$item->id]["pendente"]   += $item->pendente;
            $data['fnic_json'][$key][$item->id]["talvez"]     += $item->talvez;
          }
          sleep(0.5);
        }
        sleep(0.5);
      }
      sleep(0.5);

      dd($data);

      // ordenação array list por 'name'
      foreach (['fngp', 'fncg', 'fntp'] as $key) {
        $tmp = array_values($data['fnic_json'][$key]);
        array_multisort(array_column($tmp, 'name'), SORT_ASC, $tmp);

        // calcula o percentual de cada item da list
        foreach ($tmp as $key_item => $item) {

          if ($item['fntp'] == 1 && $data['fnic_json']['receita'] > 0) {
            $percentual = $item['total'] / $data['fnic_json']['receita'];
          } else
                      if ($item['fntp'] == 2 && $data['fnic_json']['despesa'] > 0) {
            $percentual = $item['total'] / $data['fnic_json']['despesa'];
          }

          $percentual *= 100;

          $tmp[$key_item]['percentual'] = number_format($percentual, 4, '.', '');
        }
        sleep(0.5);

        $data['fnic_json'][$key] = $tmp;
      }
      sleep(0.5);
    }

    $data['fnic_json'] = json_encode($data['fnic_json']);

    return $data;
  }

  public function formatData($items)
  {
    // retorno inicial
    $base = [
      'id'         => '',
      'name'       => '',
      'fntp'       => 0,
      'total'      => 0,
      'percentual' => 0,
      'pago'       => 0,
      'pendente'   => 0,
      'talvez'     => 0,
      'divisao_total'      => 0,
      'divisao_percentual' => 0,
      'divisao_compatible' => 0,
    ];


    $json_data = [
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


    // APURA VALORES TOTAIS
    foreach ($items as $item) {
      $fntp_id = $item['fntp_id'];
      $fnis_id = $item['fnis_id'];

      $json_data['receita'] += ($fntp_id == 1) ? $item['fnit_value'] : 0;
      $json_data['despesa'] += ($fntp_id == 2) ? $item['fnit_value'] : 0;
      $json_data['sobra']    = $json_data['receita'] - $json_data['despesa'];

      if ($fnis_id == 1) {
        $json_data['estimado'] = $json_data['receita'] - $json_data['despesa'];
      }
    }
    sleep(0.5);

    $json_data['receita']  = number_format($json_data['receita'], 2, '.', '');
    $json_data['despesa']  = number_format($json_data['despesa'], 2, '.', '');
    $json_data['sobra']    = number_format($json_data['sobra'], 2, '.', '');
    $json_data['estimado'] = number_format($json_data['estimado'], 2, '.', '');


    // APURA VALORES
    foreach ($items as $key_item => $item) {

      // pago - pendente - talvez
      $fnis_name = strtolower($item['fnis']['fnis_description']);

      foreach (['fngp', 'fncg', 'fntp'] as $key) {

        $id = $item["{$key}_id"];

        if (key_exists($id, $json_data[$key]) == false) {
          $json_data[$key][$id] = $base;

          $json_data[$key][$id]['id']   = $id;
          $json_data[$key][$id]['name'] = $item[$key]["{$key}_description"];
          $json_data[$key][$id]['fngp'] = null;
          $json_data[$key][$id]['fncg'] = null;
          $json_data[$key][$id]['fntp'] = $item["fntp_id"];

          if ($key !== 'fntp') {
            $json_data[$key][$id]['fngp'] = $item["fngp_id"];
            $json_data[$key][$id]['fncg'] = $item["fncg_id"];
          }
        }

        $json_data[$key][$id]['total']    += $item['fnit_value'];
        $json_data[$key][$id][$fnis_name] += $item['fnit_value'];


        # DIVISÃO 
        $key_obj = "{$key}_attr";

        // identifica a divisao configurada para usar
        $divisao_value = isset($this->fnct_json->$key_obj->$id)
          ? $this->fnct_json->$key_obj->$id
          : 0;

        // identifica o total para usar
        $total = ($item['fntp_id'] == 1)
          ? +$json_data['receita']
          : +$json_data['despesa'];

        // encontra o valor esperado da divisão de metas
        $json_data[$key][$id]['divisao_total']      = +number_format(($total * $divisao_value) / 100, 2, '.', '');
        // grava divisão configurada 
        $json_data[$key][$id]['divisao_percentual'] = $divisao_value;
        // valida se o valor TOTAL é menor ou igual ao valor DIVISÃO TOTAL (valor esperado)
        $json_data[$key][$id]['divisao_compatible'] = +$json_data[$key][$id]['total'] <= $json_data[$key][$id]['divisao_total'] ? true : false;
      }

      unset($items[$key_item]);
    }

    unset($items, $item, $fnis_name, $p);
    sleep(0.5);

    // ordenação array list por 'name'
    foreach (['fngp', 'fncg', 'fntp'] as $key) {
      $tmp = array_values($json_data[$key]);
      array_multisort(array_column($tmp, 'name'), SORT_ASC, $tmp);

      // calcula o percentual de cada item da list
      foreach ($tmp as $key_item => $item) {
        $percentual = 0;

        if ($item['fntp'] == 1 && $json_data['receita'] > 0) {
          $percentual = $item['total'] / $json_data['receita'];
        } else
                  if ($item['fntp'] == 2 && $json_data['despesa'] > 0) {
          $percentual = $item['total'] / $json_data['despesa'];
        }

        $percentual *= 100;

        $tmp[$key_item]['fntp']       = $item["fntp"];
        $tmp[$key_item]['pago']       = number_format($tmp[$key_item]['pago'], 2, '.', '');
        $tmp[$key_item]['pendente']   = number_format($tmp[$key_item]['pendente'], 2, '.', '');
        $tmp[$key_item]['talvez']     = number_format($tmp[$key_item]['talvez'], 2, '.', '');
        $tmp[$key_item]['total']      = number_format($tmp[$key_item]['total'], 2, '.', '');
        $tmp[$key_item]['percentual'] = number_format($percentual, 4, '.', '');
      }
      
      $json_data[$key] = $tmp;
      $json_data["{$key}_grafico"] = array_map(function($item){
          return [
            'fntp'  => $item['fntp'],
            'label' => $item['name'],
            'value' => $item['total'],
          ];
      },$tmp);

    }
    sleep(0.5);

    return $json_data;
  }
}
