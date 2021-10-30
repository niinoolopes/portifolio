<?php

namespace App\Http\Resources\Financa\Item;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancaItemResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'fnit_id'     => $this->fnit_id,
      'fnit_value'  => (float)number_format($this->fnit_value, 2, '.', ''),
      'fnit_date'   => $this->fnit_date,
      'fnit_obs'    => $this->fnit_obs,
      'fnit_enable' => abs($this->fnit_enable),
      "fnis_id"     => $this->fnis_id,
      'fnis'        => [
        "fnis_id"          => $this->fnis->fnis_id,
        "fnis_description" => $this->fnis->fnis_description,
      ],
      "fntp_id"     => $this->fntp_id,
      'fntp'        => [
        "fntp_id"          => $this->fntp->fntp_id,
        "fntp_description" => $this->fntp->fntp_description,
      ],
      "fnct_id"     => $this->fnct_id,
      'fnct'        => [
        "fnct_id"          => $this->fnct->fnct_id,
        "fnct_description" => $this->fnct->fnct_description,
      ],
      "fngp_id"     => $this->fngp_id,
      'fngp'        => [
        "fngp_id"          => $this->fngp->fngp_id,
        "fngp_description" => $this->fngp->fngp_description,
      ],
      "fncg_id"     => $this->fncg_id,
      'fncg'        => [
        "fncg_id"          => $this->fncg->fncg_id,
        "fncg_description" => $this->fncg->fncg_description,
      ],
    ];
  }
}
