<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaConsolidadoItemYearModel extends Model
{
  use HasFactory;

  public  $timestamps = false;

  protected $primaryKey = 'fnciy_id';

  protected $table = "api_crm_financa_consolidado_item_year";

  protected $fillable = [
    'fnciy_year',
    'fnciy_json',
    'fnct_id'
  ];
}
