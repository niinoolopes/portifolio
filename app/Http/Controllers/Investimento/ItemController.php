<?php

namespace App\Http\Controllers\Investimento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Investimento\Item  as I_ItemModel;
use App\Model\Investimento\Ativo as I_AtivoModel;
use App\Model\Investimento\Ordem as I_Ordem;
use App\Rule\Investimento_CarteiraItem as I_CarteiraItem;

class ItemController extends Controller
{

  private $result;

  public function __construct()
  {
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 0');

    $this->item   = new I_ItemModel;
    $this->ativo  = new I_AtivoModel;
  }

  
  public function get($id = false)
  {
    if( !isset($_GET['usuario'])) return response()->json([ 'STATUS' => 'error', 'msg' => 'o id do usuario é obrigatório']);
    
    $this->result = $this->item->get($_GET, $id);
    
    try{
      return response()->json(['STATUS'  => 'success','data' => $this->result]);

    }
    catch (\Exception $e){
      return response()->json(['STATUS'  => 'erro', 'msg' => 'Erro ao executar Model']);

    }
  }

  public function store(Request $request)
  {
    if(!isset($_GET['usuario'])) die(json_encode([ 'STATUS' => 'error', 'msg' => 'o id do usuario é obrigatório']));

    try{
      $this->item->INIT_NEGOCIACAO  = $request->get('INIT_NEGOCIACAO');
      $this->item->INIT_CV          = $request->get('INIT_CV');
      $this->item->INIT_MERCADO     = $request->get('INIT_MERCADO');
      $this->item->INIT_COTAS       = $request->get('INIT_COTAS');
      $this->item->INIT_PRECO_UNICO = $request->get('INIT_PRECO_UNICO');
      $this->item->INIT_PRECO_TOTAL = $request->get('INIT_PRECO_TOTAL');
      $this->item->INIT_DC          = $request->get('INIT_DC');
      $this->item->INIT_STATUS      = $request->get('INIT_STATUS');
      $this->item->INOD_ID          = $request->get('INOD_ID');
      $this->item->INAV_ID          = $request->get('INAV_ID');
      $this->item->save();

      $STATUS = 'success';
      $result = $this->item;


      $ordem = new I_Ordem;
      $ordem = $ordem->get([
        'usuario' => $_GET['usuario'],
        'INOD_ID' => $request->get('INOD_ID'),
      ]);
      $ordem = (count($ordem) > 0) ? reset($ordem) : $ordem;
  
      $this->consolidaAtivo([
        'usuario' => $_GET['usuario'],
        'INCT_ID' => $ordem->INCT_ID,
        'INAV_ID' => $request->get('INAV_ID'),
        'dataDe'  => date('Y-m-d', strtotime($ordem->INOD_DATA . '-2 month')),
      ]);
    }
    catch (\Exception $e){
      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'Erro ao executar Controller/Investimento/item/store'
      ];

    }

    return response()->json(['STATUS' => $STATUS, 'data' => $result]);
  }
  
  public function update($id, Request $request)
  {
    if(!isset($_GET['usuario'])) die(json_encode([ 'STATUS' => 'error', 'msg' => 'o id do usuario é obrigatório']));

    $item = $this->item->find($id);

    if($item){
      
      try{
        $item->INIT_NEGOCIACAO  = $request->get('INIT_NEGOCIACAO');
        $item->INIT_CV          = $request->get('INIT_CV');
        $item->INIT_MERCADO     = $request->get('INIT_MERCADO');
        $item->INIT_COTAS       = $request->get('INIT_COTAS');
        $item->INIT_PRECO_UNICO = $request->get('INIT_PRECO_UNICO');
        $item->INIT_PRECO_TOTAL = $request->get('INIT_PRECO_TOTAL');
        $item->INIT_DC          = $request->get('INIT_DC');
        $item->INIT_STATUS      = $request->get('INIT_STATUS');
        $item->INOD_ID          = $request->get('INOD_ID');
        $item->INAV_ID          = $request->get('INAV_ID');
        $item->save();

        $STATUS = 'success';
        $result = $item;


        $ordem = new I_Ordem;
        $ordem = $ordem->get([
          'usuario' => $_GET['usuario'],
          'INOD_ID' => $request->get('INOD_ID'),
        ]);
        $ordem = (count($ordem) > 0) ? reset($ordem) : $ordem;
    
        $this->consolidaAtivo([
          'usuario' => $_GET['usuario'],
          'INCT_ID' => $ordem->INCT_ID,
          'INAV_ID' => $request->get('INAV_ID'),
          'dataDe'  => date('Y-m-d', strtotime($ordem->INOD_DATA . '-2 month')),
        ]);
      }
      catch (\Exception $e){
  
        $STATUS = 'erro';
        $result   = (object) [
          'msg' => 'Erro ao executar Controller/Investimento/item/update'
        ];
      }

    } else {
        
      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'o ID não existe.'
      ];
    }

    return response()->json(['STATUS' => $STATUS, 'data' => $result]);
  }
  
  public function delete($id)
  {
    if(!isset($_GET['usuario'])) die(json_encode([ 'STATUS' => 'error', 'msg' => 'o id do usuario é obrigatório']));

    $item = $this->item->find($id);

    if($item){

      try{
        
        $STATUS = 'success';
        $result = $item->delete();

        
        $ordem = new I_Ordem;
        $ordem = $ordem->get([
          'usuario' => $_GET['usuario'],
          'INOD_ID' => $item->INOD_ID,
        ]);
        $ordem = (count($ordem) > 0) ? reset($ordem) : $ordem;
    
        $this->consolidaAtivo([
          'usuario' => $_GET['usuario'],
          'INCT_ID' => $ordem->INCT_ID,
          'INAV_ID' => $item->INAV_ID,
          'dataDe'  => date('Y-m-d', strtotime($ordem->INOD_DATA . '-2 month')),
        ]);

      }
      catch (\Exception $e){

        $STATUS = 'erro';
        $result   = (object) [
          'msg' => 'Erro ao executar Controller/Investimento/Item/delete'
        ];
      }

    } else {
          
      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'o INIT_ID não existe.'
      ];
    }

    // --

    return response()->json(['STATUS' => $STATUS, 'data' => $result]);
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