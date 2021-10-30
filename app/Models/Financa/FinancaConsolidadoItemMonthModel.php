<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaConsolidadoItemMonthModel extends Model
{
  use HasFactory;

  public  $timestamps = false;
  
  protected $primaryKey = 'fncim_id';

  protected $table = "api_crm_financa_consolidado_item_month";

  protected $fillable = [
    'fncim_year',
    'fncim_month',
    'fncim_json',
    'fnct_id'
  ];

}
