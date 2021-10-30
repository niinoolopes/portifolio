<?php

namespace App\Http\Resources\Financa\Categoria;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancaCategoriaResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "fncg_id"          => $this->fncg_id,
      "fncg_description" => $this->fncg_description,
      "fncg_obs"         => $this->fncg_obs,
      "fncg_enable"      => intval($this->fncg_enable),
      "fncg_fechamento"  => intval($this->fncg_fechamento),
      "fngp_id"          => $this->fngp_id,
      "fngp"             => [
        "fngp_id"          => $this->fngp->fngp_id,
        "fngp_description" => $this->fngp->fngp_description,
        "fntp"             => [
          "fntp_id"          => $this->fngp->fntp_id,
        ],
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
