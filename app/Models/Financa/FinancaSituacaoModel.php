<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaSituacaoModel extends Model
{
  use HasFactory;

  public  $timestamps = false;

  protected $primaryKey = 'fnis_id';

  protected $table = "api_crm_financa_situacao";
}
