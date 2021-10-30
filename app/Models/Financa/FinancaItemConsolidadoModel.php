<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaItemConsolidadoModel extends Model
{
  use HasFactory;

  protected $primaryKey = 'fnic_id';

  protected $table = "api_crm_financa_consolidado_item";

  protected $fillable = [
    'fnic_date',
    'fnic_json',
    'fnct_id'
  ];

  public function fnct()
  {
    return $this->hasOne("App\Models\Financa\FinancaCarteiraModel", 'fnct_id', 'fnct_id');
  }
}
