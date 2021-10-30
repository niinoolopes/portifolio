<?php

namespace App\Http\Resources\Financa\ItemConsolidado;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancaItemConsolidadoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      "fnic_id"   => $this->fnic_id,
      "fnic_json" => json_decode($this->fnic_json),
      "fnic_date" => $this->fnic_date,
      "fnct_id"   => $this->fnct_id,
    ];
  }
}
