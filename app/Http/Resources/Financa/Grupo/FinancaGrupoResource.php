<?php

namespace App\Http\Resources\Financa\Grupo;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancaGrupoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "fngp_id"          => $this->fngp_id,
      "fngp_description" => $this->fngp_description,
      "fngp_enable"      => intval($this->fngp_enable),
      "fngp_fechamento"  => intval($this->fngp_fechamento),
      "fntp_id"          => $this->fntp_id,
      "fntp"             => [
        "fntp_id"          => $this->fntp->fntp_id,
        "fntp_description" => $this->fntp->fntp_description,
      ],
      "fnct_id"          => $this->fnct_id,
      "fnct"             => [
        "fnct_id"          => $this->fnct->fnct_id,
        "fnct_description" => $this->fnct->fnct_description,
        "fnct_enable"      => $this->fnct->fnct_enable,
      ],
    ];
  }
}
