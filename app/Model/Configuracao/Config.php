<?php

namespace App\Model\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\DBTables;

class Config extends Model {

  private $DBTables;
  
  protected $table;
  
  protected $primaryKey = 'CNFG_ID';

  public $timestamps = false;

  // --

  public function __construct() {
    $this->DBTables = new DBTables;
    $this->table    = $this->DBTables->config;
  }
  
  // --

  public function get($get)
  {
    $USUA_ID        = $get['usuario'];
    $CNFG_DESCRICAO = isset($get['CNFG_DESCRICAO']) ? $get['CNFG_DESCRICAO'] : false;

    // --

    $sql  = "SELECT ";
    $sql .= "CNFG.CNFG_ID, CNFG.CNFG_DESCRICAO, CNFG.CNFG_VALOR, CNFG.CNFG_STATUS, ";
    $sql .= "USUA.USUA_ID ";
    $sql .= "FROM {$this->DBTables->config}        CNFG ";
    $sql .= "INNER JOIN {$this->DBTables->usuario} USUA ON USUA.USUA_ID = CNFG.USUA_ID ";
    $sql .= "WHERE CNFG.USUA_ID = {$USUA_ID} ";
    
    if( $CNFG_DESCRICAO !== false) $sql .= "AND CNFG.CNFG_DESCRICAO = '{$CNFG_DESCRICAO}' ";

    $sql .= ";";
    
    // die($sql);
    return DB::select($sql);
  }
}