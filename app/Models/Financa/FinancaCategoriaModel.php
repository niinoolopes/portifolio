<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaCategoriaModel extends Model
{
  use HasFactory;

  protected $primaryKey = 'fncg_id';

  protected $table = "api_crm_financa_categoria";

  protected $fillable = [
    'fncg_description',
    'fncg_obs',
    'fncg_enable',
    'fncg_fechamento',
    'fngp_id',
    'fnct_id',
  ];

  protected $hidden = [
    'usua_id',
  ];

  public function fngp()
  {
    return $this->hasOne("App\Models\Financa\FinancaGrupoModel", 'fngp_id', 'fngp_id');
  }

  public function fnct()
  {
    return $this->hasOne("App\Models\Financa\FinancaCarteiraModel", 'fnct_id', 'fnct_id');
  }
}
