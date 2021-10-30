<?php

namespace App\Models\Financa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancaGrupoModel extends Model
{
  use HasFactory;

  protected $primaryKey = 'fngp_id';

  protected $table = "api_crm_financa_grupo";

  protected $fillable = [
    'fngp_description',
    'fngp_enable',
    'fngp_fechamento',
    'fntp_id',
    'fnct_id',
  ];

  protected $hidden = [
    'usua_id',
  ];

  public function fntp()
  {
    return $this->hasOne("App\Models\Financa\FinancaTipoModel", 'fntp_id', 'fntp_id');
  }

  public function fnct()
  {
    return $this->hasOne("App\Models\Financa\FinancaCarteiraModel", 'fnct_id', 'fnct_id');
  }
}
