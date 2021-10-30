<?php

namespace App\Http\Resources\Coleta;

use Illuminate\Http\Resources\Json\JsonResource;

class ColetaResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'cole_id'     => $this->cole_id,
      'cole_date'   => $this->cole_date,
      'cole_price'  => $this->cole_price,
      'cole_status' => $this->cole_status,
      'clie_id'     => $this->clie_id,
      'cols_id'     => $this->cols_id,
      'end'        => $this->end,
      'clie'        => $this->clie,
      'motr'        => $this->motr,
      'finc'        => $this->finc,
      'colp'        => $this->colp,
      'colh'        => $this->colh,
      'cols'        => $this->cols,
    ];
  }
}
