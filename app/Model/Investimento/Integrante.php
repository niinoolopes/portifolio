<?php

namespace App\Model\Investimento;

use Illuminate\Database\Eloquent\Model;
use App\Model\DBTables;

class Integrante extends Model {

  private $DBTables;
  
  protected $table;
  
  protected $primaryKey = 'INTG_ID';

  public  $timestamps = false;

  // --

  public function __construct() {
    $this->DBTables = new DBTables;
    $this->table    = $this->DBTables->InvestIntegrante;
  }
}


