<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Investimento\Ativo        as I_AtivoModel;
use App\Model\Investimento\AtivoCotacao as I_AtivoCotacaoModal;
use App\Model\Investimento\CarteiraItem as I_CarteiraItemModel;
use App\Rule\Investimento_CarteiraItem  as I_CarteiraItem;
use App\Model\Configuracao\Config       as C_ConfigModel;

class Rotina extends Controller 
{
  public function __construct()
  {

    $this->I_ativo             = new I_AtivoModel;
    $this->I_ativoCotacao      = new I_AtivoCotacaoModal;
    $this->I_carteiraItem      = new I_CarteiraItem;
    $this->I_carteiraItemModel = new I_CarteiraItemModel;
    $this->C_configModel       = new C_ConfigModel;

  }
  
  public function get($tipo) {
    if( !isset($_GET['usuario'])) return response()->json(['STATUS' => 'error', 'msg' => 'o USUARIO é uma parametro obrigatório']);

    // tipo original
    $tipoOriginal = $tipo;

    // tratamento para chamada do metodo
    $tipo   = str_replace('-', ' ',$tipo);
    $tipo   = ucwords($tipo);
    $tipo   = str_replace(' ', '',$tipo);
    $method = "get{$tipo}";


    if( !method_exists($this, $method) ){
      return response()->json(
        [
        'STATUS' => 'error', 
        'msg' => "o método informado '{$tipoOriginal}' não existe."
        ]
      );
    }
    

    $result = $this->$method();
    try{
      $STATUS = 'success';
    }
    catch (\Exception $e){

      $STATUS = 'erro';
      $result   = (object) [
        'msg' => "Erro ao executar Rotina/{$tipoOriginal}"
      ];
    }

    return response()->json(['STATUS'  => $STATUS, 'data' => $result]);
  }

  public function getInvestimentoBuscaCotacao()
  {
    if(!isset($_GET['INCT'])) die( json_encode(['STATUS' => 'error', 'msg' => "o 'INCT' é uma parametro obrigatório"]) );

    $USUA_ID = $_GET['usuario'];
    $INCT_ID = $_GET['INCT'];
    
    $CNFG = C_ConfigModel::where('USUA_ID'   , '=', $USUA_ID)
                         ->where('CNFG_DESCRICAO', '=', 'inv-cotacao-link-planilha')
                         ->first();

    if($CNFG == null)
      die(
        json_encode([
          'STATUS' => 'error', 
          'msg' => "Não existe LINK PLANILHA GOOGLE para o usuario {$USUA_ID}."
        ])
      );
      
    if(empty($CNFG->CNFG_VALOR))
      die(
        json_encode([
          'STATUS' => 'error', 
          'msg' => "O LINK PLANILHA GOOGLE para o usuario {$USUA_ID} esta em branco."
        ])
      );

        
    // $URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSy-YQ9gN3YsbqqDCr5I2f_-X01vVZvzXg5cucONbwtYE7goUqVrRI2Jhe8GfiIWTYnuCA5-pxt7CeB/pub?gid=0&single=true&output=csv';
    $URL = $CNFG->CNFG_VALOR;


    // BUSCA DADOS
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      unset($curl);

    
    // format retorno
      $response = str_replace("\r\n",'|',$response);
      $arrDados = explode('|',$response);


    if(count($arrDados) <= 1)
      die(
        json_encode([
          'STATUS' => 'error', 
          'msg' => "a Planilha não contem registros"
        ])
      );


    // remove cabeçalho
      unset($arrDados[0]);

      
    // FORMAT
      foreach ($arrDados as $key_item => $item) {
        $tmp = explode(',', $item);

        $codigo       = $tmp[0];
        $cotacaoSaldo = $tmp[1];
        $cotacaoCents = $tmp[2];

        $num = str_replace('"', '', "{$cotacaoSaldo}.{$cotacaoCents}");
        $num = intval($num);

        if($num > 0) {
          $arrDados[$codigo] = (object)[
            'COTACAO' => number_format($num, 2, '.', '')
          ];
  
          $INAV_CODIGO[$codigo] = "'$codigo'";
        }

        unset($arrDados[$key_item]);
      }


    // BUSCA ATIVOS BY CODIGO
      $ativos = $this->I_ativo->get([
        'usuario'     => $USUA_ID,
        'status'      => 1,
        'INAV_CODIGO' => array_values($INAV_CODIGO),
      ]);


    // SAVE COTACAO
    foreach ($ativos as $key_ativo => $ativo) {
      
      $result = $this->I_carteiraItemModel->get([
        'usuario' => $USUA_ID,
        'INCT_ID' => $INCT_ID,
        'INAV_ID' => $ativo->INAV_ID,
      ]);

      // TRATA APENAS QUANDO EXISTIR CONSOLIDADO MES DO ATIVO 
      if(count($result) > 0) {

        $INCTC = end($result);
        $INCTC_CONTENT = json_decode($INCTC->INCTC_CONTENT);

        // SALVA COTAÇÃO APENAS QUANDO EXISTIR 'COTAS > 0' AO ATIVO
        if($INCTC_CONTENT->COTAS > 0) {

          $ativoCotacao = new I_AtivoCotacaoModal;
          $ativoCotacao->INAC_VALOR   = $arrDados[$ativo->INAV_CODIGO]->COTACAO;
          $ativoCotacao->INAC_DATA    = date('Y-m-d');
          $ativoCotacao->INAC_STATUS  = 1;
          $ativoCotacao->INAV_ID      = $ativo->INAV_ID;
          $ativoCotacao->USUA_ID      = $ativo->USUA_ID;
          $ativoCotacao->save();
    
          $INAV_ID[$ativo->INAV_ID] = $ativo->INAV_ID;
          ksort($INAV_ID);
        }
      }

      unset($arrDados[$ativo->INAV_CODIGO]);
    }


    $consolidaAtivo = $this->consolidaAtivo([
      'usuario' => $USUA_ID,
      'INCT_ID' => $INCT_ID,
      'INAV_ID' => implode('|', array_values($INAV_ID)),
      'dataDe'  => date('Y-m-d',strtotime(date('Y-m-d') . '-2 month')),
    ]);

    return true;
  }
  

  public function consolidaAtivo($options) {
    if( !isset($options['usuario'])) die(json_encode(['STATUS' => 'error', 'msg' => 'o usuario é uma parametro obrigatório']));

    $I_CarteiraItem = new I_CarteiraItem;
      
    $I_CarteiraItem->options = [
      'USUA_ID' => $options['usuario'],
      'INCT_ID' => $options['INCT_ID'],
      'INCR_ID' => isset($options['INCR_ID']) ? $options['INCR_ID'] : false,
      'dataAte' => date('Y-m-d'),
      'dataDe'  => isset($options['dataDe'])  ? $options['dataDe']  : false,
      'INAV_ID' => isset($options['INAV_ID']) ? $options['INAV_ID'] : false,
      'INTP_ID' => isset($options['INTP_ID']) ? $options['INTP_ID'] : false,
    ];

    return $I_CarteiraItem->exec();
  }

}