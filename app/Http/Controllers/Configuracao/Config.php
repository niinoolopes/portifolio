<?php

namespace App\Http\Controllers\Configuracao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Configuracao\Config as C_ConfigModel;

class Config extends Controller 
{
  public function __construct()
  {
    $this->C_configModel = new C_ConfigModel;

  }
  
  public function get() {
    if( !isset($_GET['usuario'])) return response()->json(['STATUS' => 'error', 'msg' => 'o USUARIO é obrigatório']);
    
    try{
      $STATUS = 'success';
      $result = $this->C_configModel->get($_GET);
    }
    catch (\Exception $e){

      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'Erro ao executar Controller/Configuracao/Config/get'
      ];
    }

    return response()->json(['STATUS'  => $STATUS, 'data' => $result]);
  }
  
  public function store(Request $request) {
    if( !isset($_GET['usuario'])) return response()->json(['STATUS' => 'error', 'msg' => 'o USUARIO é obrigatório']);

    try{
      $C_configModel = $this->C_configModel;
      $C_configModel->CNFG_DESCRICAO = $request->get('CNFG_DESCRICAO');
      $C_configModel->CNFG_VALOR     = $request->get('CNFG_VALOR');
      $C_configModel->CNFG_STATUS    = $request->get('CNFG_STATUS');
      $C_configModel->USUA_ID        = $_GET['usuario'];
      $C_configModel->save();

      // --

      $STATUS = 'success';
      $result = $C_configModel;
    }
    catch (\Exception $e){

      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'Erro ao executar Controller/Configuracao/Config/store'
      ];
    }

    // --

    return response()->json(['STATUS'  => $STATUS, 'data' => $result]);
  }
  
  public function update($INAT_ID, Request $request) {
    $C_configModel = $this->C_configModel->find($INAT_ID);

    if($C_configModel){

      try{
        // update
        $C_configModel->CNFG_DESCRICAO = $request->get('CNFG_DESCRICAO');
        $C_configModel->CNFG_VALOR     = $request->get('CNFG_VALOR');
        $C_configModel->CNFG_STATUS    = $request->get('CNFG_STATUS') ? 1 : 0;
        $C_configModel->USUA_ID        = $_GET['usuario'];
        // $C_configModel->USUA_ID        = $request->get('USUA_ID');
        $C_configModel->save();
        
        // --
  
        $STATUS = 'success';
        $result = $C_configModel;
      }
      catch (\Exception $e){

        $STATUS = 'erro';
        $result   = (object) [
          'msg' => 'Erro ao executar Controller/Configuracao/Config/update'
        ];
      }

    } else {
      
      $STATUS = 'erro';
      $result   = (object) [
        'msg' => 'o ID não existe.'
      ];
    }

    // --

    return response()->json(['STATUS' => $STATUS, 'data' => $result]);
  }
}