<?php

namespace App\Model\Investimento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\DBTables;

class Ativo extends Model {

  private $DBTables;

  protected $table;
  
  protected $primaryKey = 'INAV_ID';

  public  $timestamps = false;
  
  // --
  
  public function __construct()
  {
    $this->DBTables = new DBTables;
    $this->table    = $this->DBTables->InvestAtivo;
  }

  public function get($get) {
    $USUA_ID     = $get['usuario'];
    $INAV_ID     = isset($get['INAV_ID'])     ? $get['INAV_ID'] : false;
    $INAV_CODIGO = isset($get['INAV_CODIGO']) ? $get['INAV_CODIGO'] : false;
    $INAV_STATUS = isset($get['status'])      ? $get['status']  : false;
    $orderby     = isset($get['orderby'])     ? $get['orderby'] : false;

    // --

    $sql  = "SELECT ";
    $sql .="INAV.INAV_ID, INAV.INAV_DESCRICAO, INAV.INAV_CODIGO, INAV_CPNJ, INAV_SITE, INAV_LIQUIDEZ, INAV_VENC, INAV.INAV_STATUS, ";
    $sql .="INAT.INAT_ID, INAT.INAT_DESCRICAO, INAT.INAT_STATUS, ";
    $sql .="INTP.INTP_ID, INTP.INTP_DESCRICAO, INTP.INTP_STATUS, ";
    $sql .="USUA.USUA_ID, USUA.USUA_NOME ";
    $sql .= "FROM       {$this->DBTables->InvestAtivo}      INAV ";
    $sql .= "INNER JOIN {$this->DBTables->InvestAtivoTipo}  INAT ON INAT.INAT_ID = INAV.INAT_ID ";
    $sql .= "INNER JOIN {$this->DBTables->InvestTipo}       INTP ON INTP.INTP_ID = INAT.INTP_ID ";
    $sql .= "INNER JOIN {$this->DBTables->usuario}          USUA ON USUA.USUA_ID = INAV.USUA_ID ";
    $sql .= "WHERE USUA.USUA_ID = {$USUA_ID} ";
    
    if( $INAV_ID     !== false) $sql .= "AND INAV.INAV_ID = {$INAV_ID} ";
    if( $INAV_STATUS !== false) $sql .= "AND INAV.INAV_STATUS = {$INAV_STATUS} ";

    if($INAV_CODIGO !== false && !is_array($INAV_CODIGO)) 
      $sql .= "AND INAV.INAV_CODIGO = {$INAV_CODIGO} ";
    if($INAV_CODIGO !== false && (is_array($INAV_CODIGO) && count($INAV_CODIGO) > 0)) 
      $sql .= "AND INAV.INAV_CODIGO IN (". implode(', ', $INAV_CODIGO).") ";
    
    if($orderby){
      $orderby = explode('|', $orderby);
      $orderby = array_map( function($val){ return  substr($val, 0, 4) . "." . str_replace(':', ' ', $val); }, $orderby);
      $orderby = implode(', ',$orderby);
      $sql .= "ORDER BY {$orderby} ";

    } else {
      $sql .= "ORDER BY INAV.INAV_CODIGO ASC ";

    }
    // die($sql);
    return DB::select($sql);
  }
  
}