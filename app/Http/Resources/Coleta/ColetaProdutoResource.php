<?php

namespace App\Http\Resources\Coleta;

use Illuminate\Http\Resources\Json\JsonResource;

class ColetaProdutoResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'colp_id' => $this->colp_id,
      'colp_description' => $this->colp_description,
      'colp_quantity' => $this->colp_quantity,
      'colp_price_unit' => $this->colp_price_unit,
      'colp_price' => $this->colp_price,
      'colp_status' => $this->colp_status,
      'cole_id' => $this->cole_id,
      'copt_id' => $this->copt_id,
      'copt' => $this->copt,
    ];
  }
}
