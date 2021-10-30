<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaItemModel extends Model
{
  use HasFactory;

  protected $primaryKey = 'fnit_id';

  protected $table = "api_crm_financa_item";

  protected $fillable = [
    'fnit_value',
    'fnit_date',
    'fnit_obs',
    'fnit_enable',
    'fnis_id',
    'fntp_id',
    'fnct_id',
    'fngp_id',
    'fncg_id',
  ];

  protected $hidden = [
    'usua_id',
  ];

  public function fnis()
  {
    return $this->hasOne("App\Models\Financa\FinancaSituacaoModel", 'fnis_id', 'fnis_id');
  }

  public function fntp()
  {
    return $this->hasOne("App\Models\Financa\FinancaTipoModel", 'fntp_id', 'fntp_id');
  }

  public function fnct()
  {
    return $this->hasOne("App\Models\Financa\FinancaCarteiraModel", 'fnct_id', 'fnct_id');
  }

  public function fngp()
  {
    return $this->hasOne("App\Models\Financa\FinancaGrupoModel", 'fngp_id', 'fngp_id');
  }

  public function fncg()
  {
    return $this->hasOne("App\Models\Financa\FinancaCategoriaModel", 'fncg_id', 'fncg_id');
  }
}
